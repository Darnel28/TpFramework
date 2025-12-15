<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Utilisateurs;
use App\Traits\CloudinaryUpload;

class AuthController extends Controller
{
    use CloudinaryUpload;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Rediriger selon le rôle
            $user = Auth::user();
            $role = $user->id_role ?? null;

            if ($role == 2) {
                return redirect()->route('admin.accueil')->with('success', 'Connexion réussie !');
            }

            if ($role == 3) {
                return redirect()->route('moderateur.accueil')->with('success', 'Connexion réussie !');
            }

            // Utilisateur standard -> contribution
            return redirect()->route('contribute')->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:6|confirmed',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'terms' => 'required'
        ]);

        $user = new Utilisateurs();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->mot_de_passe = Hash::make($request->password);
        $user->sexe = $request->sexe;
        $user->date_naissance = $request->date_naissance;
        $user->date_inscription = now();
        $user->statut = 'actif';
         $user->id_role = 4; // Par défaut: contributeur
        $user->id_langue = 6; // Par défaut: Français
        
        // Handle photo upload avec Cloudinary
        if ($request->hasFile('photo')) {
            $photoUrl = $this->storeOnCloudinary($request->file('photo'), 'culturebenin/profiles');
            if ($photoUrl) {
                $user->photo = $photoUrl;
            }
        }
        
        try {
            $saved = $user->save();
            if (! $saved) {
                Log::error('AuthController::register - save() returned false for utilisateur', ['email' => $user->email]);
                return back()->withInput()->withErrors(['error' => 'Impossible de créer le compte, veuillez réessayer.']);
            }

            // Auto login after registration
            Auth::login($user);

            return redirect()->route('contribute')->with('success', 'Inscription réussie ! Vous pouvez maintenant contribuer.');
        } catch (\Throwable $e) {
            // Log the exception for debugging
            Log::error('AuthController::register exception when saving utilisateur: ' . $e->getMessage(), [
                'exception' => $e,
                'input' => $request->except('password', 'password_confirmation')
            ]);

            return back()->withInput()->withErrors(['error' => 'Une erreur est survenue lors de la création du compte. Veuillez vérifier les logs.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}