<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\utilisateurs as Utilisateur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Accept 'nom' and 'prenom' from the form and build a 'name' value
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Créer un enregistrement dans la table `utilisateurs` (modèle personnalisé)
        $util = new Utilisateur();
        $util->nom = $request->input('nom');
        $util->prenom = $request->input('prenom');
        $util->email = $request->input('email');
        $util->mot_de_passe = Hash::make($request->input('password'));
        $util->date_inscription = now();
        $util->statut = 'actif';
        $util->id_role = 4; // contributeur par défaut
        // id_langue: si envoyé sinon valeur par défaut (6 = Français)
        $util->id_langue = $request->input('id_langue', 6);

        // Gestion de la photo de profil
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $util->photo = $path;
        } else {
            // Ne pas forcer une URL de fichier ici : le modèle fournit l'URL par défaut
            $util->photo = null;
        }

        $user = $util;

        event(new Registered($user));

        // Sauvegarde et login
        $user->save();
        Auth::login($user);

        // Redirection vers la page de contribution
        return redirect(route('contribute') . '#contribution-form');
    }
}
