<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FedaPay\FedaPay;
use App\Models\FedapayTransaction;

class PaymentController extends Controller
{
    public function pay()
    {
        $contentId = request()->get('content_id');

        \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
        $mode = trim((string) config('services.fedapay.mode'));
        if (!in_array($mode, ['live', 'sandbox'])) {
            $mode = 'live';
        }
        \FedaPay\FedaPay::setEnvironment($mode);

        // montant fixe 100 XOF (en unité XOF)
        $amount = 100;

        try {
            $customer = null;
            if (auth()->check()) {
                $user = auth()->user();
                $customer = [
                    'email' => $user->email ?? null,
                    'first_name' => $user->prenom ?? ($user->name ?? null),
                    'last_name' => $user->nom ?? null,
                ];
            }

            // Construire des URLs absolues basées sur l'hôte courant
            $host = request()->getSchemeAndHttpHost();
            $callbackUrl = $host . route('fedapay.callback', [], false);
            $returnUrl = $host . route('content.details', $contentId ?? 0, false);
            // Forcer HTTPS pour Render
            if (str_contains($host, 'onrender.com')) {
                $callbackUrl = preg_replace('/^http:\/\//', 'https://', $callbackUrl);
                $returnUrl = preg_replace('/^http:\/\//', 'https://', $returnUrl);
            }

            $transactionData = [
                "amount" => $amount,
                "currency" => ["iso" => "XOF"],
                "description" => "Accès contenu #" . ($contentId ?? 'N/A'),
                "callback_url" => $callbackUrl,
                // Retour vers la page du contenu après paiement
                "return_url" => $returnUrl,
                "meta" => [
                    'content_id' => $contentId,
                    'user_id' => auth()->id() ?? null
                ]
            ];

            if ($customer) {
                $transactionData['customer'] = $customer;
            }

            $transaction = \FedaPay\Transaction::create($transactionData);

            // ✅ ENREGISTRER LA TRANSACTION EN BASE DE DONNÉES
            // Note: user_id doit être NULL ou correspondre à la table 'users' (pas 'utilisateurs')
            // Pour le moment, on met NULL pour éviter les conflits de clés étrangères
            
            FedapayTransaction::create([
                'fedapay_id' => $transaction->id,
                'content_id' => $contentId,
                'user_id' => null, // Pas de relation avec users pour l'instant
                'status' => 'pending',
                'amount' => $amount,
                'currency' => 'XOF',
                'metadata' => [
                    'description' => "Accès contenu #" . ($contentId ?? 'N/A')
                ]
            ]);

            $token = $transaction->generateToken();
            if (!$token || empty($token->url)) {
                // Retenter une fois via retrieve
                $transaction = \FedaPay\Transaction::retrieve($transaction->id);
                $token = $transaction->generateToken();
            }

            // Log minimal info pour debug
            \Log::info('FedaPay transaction created', ['id' => $transaction->id ?? null, 'content_id' => $contentId, 'token' => $token->id ?? null]);

            if ($token && !empty($token->url)) {
                return response()->json([
                    'payment_url' => $token->url
                ]);
            }

            \Log::error('FedaPay token generation returned empty URL', ['id' => $transaction->id ?? null, 'mode' => $mode, 'callback' => $callbackUrl, 'return' => $returnUrl]);
            return response()->json(['error' => true, 'message' => 'Paiement indisponible pour le moment.'], 500);

        } catch (\Throwable $e) {
            \Log::error('FedaPay create transaction failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => true, 'message' => 'Erreur lors de la création de la transaction. Veuillez réessayer.'], 500);
        }
    }

    public function callback(Request $request)
    {
        // Debug : log les paramètres reçus
        \Log::info('FedaPay callback received', [
            'all_params' => $request->all(),
            'query' => $request->getQueryString(),
        ]);

        // FedaPay renvoie 'id' et 'status' dans les paramètres GET
        $transaction_id = $request->get('id');
        $status_from_url = $request->get('status'); // declined, approved, etc.

        if (!$transaction_id) {
            \Log::error('FedaPay callback: No transaction_id/id provided', ['request' => $request->all()]);
            return redirect()->route('home')->with('error', 'Aucune transaction trouvée.');
        }

        // ✅ RÉCUPÉRER LA TRANSACTION DEPUIS LA BASE DE DONNÉES
        $fedapayTx = FedapayTransaction::where('fedapay_id', $transaction_id)->first();

        if (!$fedapayTx) {
            \Log::error('FedaPay transaction not found in DB', ['fedapay_id' => $transaction_id]);
            return redirect()->route('home')->with('error', 'Transaction non enregistrée.');
        }

        $contentId = $fedapayTx->content_id;

        // En SANDBOX, on peut utiliser le status directement de l'URL
        // En PRODUCTION, on fait un retrieve pour vérifier
        $isSandboxMode = config('services.fedapay.mode') === 'sandbox' || config('app.env') !== 'production';
        
        if ($isSandboxMode) {
            // Mode sandbox : utiliser directement le status de l'URL
            \Log::info('FedaPay callback SANDBOX mode', ['id' => $transaction_id, 'status' => $status_from_url, 'content_id' => $contentId]);
            $transaction = (object) [
                'id' => $transaction_id,
                'status' => $status_from_url,
            ];
        } else {
            // Mode production : vérifier la transaction via l'API
            \FedaPay\FedaPay::setApiKey(config('services.fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('services.fedapay.mode'));

            try {
                $transaction = \FedaPay\Transaction::retrieve($transaction_id);
                \Log::info('FedaPay transaction retrieved', [
                    'transaction_id' => $transaction_id,
                    'status' => $transaction->status ?? 'NO_STATUS',
                ]);
            } catch (\Throwable $e) {
                \Log::error('FedaPay retrieve failed', ['error' => $e->getMessage(), 'transaction_id' => $transaction_id]);
                return redirect()->route('home')->with('error', 'Transaction introuvable.');
            }
        }

        // Mettre à jour le status en base de données
        $fedapayTx->update(['status' => $transaction->status]);

        // En mode SANDBOX, on accepte même les paiements "declined"
        $isApproved = $transaction->status == "approved";

        \Log::info('FedaPay callback validation', [
            'isApproved' => $isApproved,
            'isSandboxMode' => $isSandboxMode,
            'contentId' => $contentId,
            'status' => $transaction->status
        ]);

        if ($isApproved || $isSandboxMode) {
            // Enregistrer dans la session que l'utilisateur a payé pour ce contenu
            if ($contentId) {
                $paid = session('paid_contents', []);
                if (!in_array($contentId, $paid)) {
                    $paid[] = $contentId;
                }
                session(['paid_contents' => $paid]);
                \Log::info('FedaPay payment recorded', ['content_id' => $contentId, 'paid_contents' => $paid]);
            }

            $message = $isApproved ? 'Paiement réussi, merci !' : 'Paiement validé en mode test (status: ' . $transaction->status . ')';

            if ($contentId) {
                return redirect()->route('content.details', $contentId)->with('success', $message);
            }

            return redirect()->route('home')->with('success', $message);
        } else {
            \Log::warning('FedaPay payment declined', ['status' => $transaction->status, 'contentId' => $contentId]);
            if ($contentId) {
                return redirect()->route('content.details', $contentId)->with('error', 'Paiement échoué. Status: ' . $transaction->status);
            }
            return redirect()->route('home')->with('error', 'Paiement échoué. Status: ' . $transaction->status);
        }
    }

    /**
     * Route de test pour paiement automatique en sandbox
     * Utilise l'API REST directe avec les paramètres de test
     */
    public function payTestSandbox()
    {
        $contentId = request()->get('content_id', 7);

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.fedapay.secret_key'),
                'Content-Type' => 'application/json'
            ])->post('https://sandbox-api.fedapay.com/v1/payments', [
                "amount" => 100,
                "currency" => "XOF",
                "description" => "Test paiement contenu #" . $contentId,
                "payment_method" => [
                    "type" => "mobile_money",
                    "operator" => "MOMO TEST",
                    "phone_number" => "03000000",
                    "otp" => "1234"
                ],
                "callback_url" => route('fedapay.callback'),
                "meta" => [
                    'content_id' => $contentId,
                    'user_id' => auth()->id() ?? null
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Ajouter directement à la session puisque c'est approuvé automatiquement
                $paid = session('paid_contents', []);
                if (!in_array($contentId, $paid)) {
                    $paid[] = $contentId;
                }
                session(['paid_contents' => $paid]);

                return redirect()->route('content.details', $contentId)
                    ->with('success', 'Paiement test réussi ! Transaction ID: ' . ($data['id'] ?? 'N/A'));
            } else {
                return redirect()->route('content.details', $contentId)
                    ->with('error', 'Paiement test échoué: ' . $response->body());
            }

        } catch (\Throwable $e) {
            \Log::error('FedaPay test payment failed', ['error' => $e->getMessage()]);
            return redirect()->route('content.details', $contentId)
                ->with('error', 'Erreur test paiement: ' . $e->getMessage());
        }
    }
}
