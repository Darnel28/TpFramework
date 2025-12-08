<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenu;

class ModeratorController extends Controller
{
    /**
     * Dashboard modérateur - liste des contenus en attente
     */
    public function index()
    {
        // Vérifier que l'utilisateur est modérateur
        if (! Auth::check() || (Auth::user()->id_role ?? null) != 3) {
            return redirect()->route('home');
        }

        // Utiliser le statut tel qu'il est enregistré en base (ex: 'en attente')
        $pending = Contenu::where('statut', 'en attente')
            ->orderBy('date_creation', 'desc')
            ->get();

        // Compteurs statiques utiles pour le tableau de bord
        $total = Contenu::count();
        $pendingCount = $pending->count();
        $publishedCount = Contenu::where('statut', 'publié')->count();

        return view('Moderateur.dashboard', compact('pending', 'total', 'pendingCount', 'publishedCount'));
    }

    /**
     * Page listant les contenus en attente (séparée)
     */
    public function contenus()
    {
        if (! Auth::check() || (Auth::user()->id_role ?? null) != 3) {
            return redirect()->route('home');
        }

        $pending = Contenu::where('statut', 'en attente')
            ->orderBy('date_creation', 'desc')
            ->get();

        return view('Moderateur.contenus', compact('pending'));
    }

    /**
     * Approve content (publier)
     */
    public function approve(Request $request, $id)
    {
        if (! Auth::check() || (Auth::user()->id_role ?? null) != 3) {
            return redirect()->route('home');
        }

        $contenu = Contenu::find($id);
        if ($contenu) {
            $contenu->statut = 'publié';
            $contenu->id_moderateur = Auth::id();
            $contenu->save();
        }

        return back()->with('success', 'Contenu approuvé.');
    }

    /**
     * Supprimer un contenu (modérateur)
     */
    public function destroy(Request $request, $id)
    {
        if (! Auth::check() || (Auth::user()->id_role ?? null) != 3) {
            return redirect()->route('home');
        }

        $contenu = Contenu::find($id);
        if ($contenu) {
            $contenu->delete();
        }

        return back()->with('success', 'Contenu supprimé.');
    }
}
