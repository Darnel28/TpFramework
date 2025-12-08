<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la vue de connexion
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la requête d'authentification
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifie l'utilisateur via le LoginRequest
        $request->authenticate();

        // Regénère la session pour la sécurité
        $request->session()->regenerate();

        // Redirection vers la page précédente ou le dashboard admin
        return redirect()->intended(route('admin.accueil'));
    }

    /**
     * Détruit la session authentifiée (déconnexion)
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // retourne vers la page de login
    }
}
