<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Region;
use App\Models\Langue;
use App\Models\Utilisateurs;
use App\Models\Contenu;

class DashboardController extends Controller
{
    // Supprimer ou commenter cette ligne pour enlever l'authentification
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $data = [
            'usersCount' => 1254,
            'moderatorsCount' => 24,
            'contentsCount' => 568,
            'languagesCount' => 5,
            'viewsCount' => 12458,
            'recentActivities' => [
                [
                    'icon' => 'fa-user-plus',
                    'description' => 'Nouvel utilisateur inscrit',
                    'time' => 'Il y a 2 heures'
                ],
                [
                    'icon' => 'fa-user-shield',
                    'description' => 'Nouveau modérateur ajouté',
                    'time' => 'Il y a 4 heures'
                ],
                [
                    'icon' => 'fa-file-upload',
                    'description' => 'Nouvelle recette ajoutée',
                    'time' => 'Il y a 5 heures'
                ],
                [
                    'icon' => 'fa-edit',
                    'description' => 'Contenu modifié',
                    'time' => 'Il y a 1 jour'
                ]
            ]
        ];

        return view('dashboard.accueil', $data);
    }

    public function utilisateurs()
    {
        
        try {
            $users = Utilisateurs::all();
            $langues = Langue::all();
        } catch (\Exception $e) {
            $users = [];
            $langues = collect();
        }

        return view('dashboard.utilisateurs', compact('users','langues'));
    }

    public function moderateurs()
    {
        // Récupère depuis la table `utilisateurs` les entrées avec id_role = 3 (modérateurs)
        try {
            $moderators = Utilisateurs::where('id_role', 3)->get();
            $langues = Langue::all();
        } catch (\Exception $e) {
            $moderators = collect();
            $langues = collect();
        }

        return view('dashboard.moderateurs', compact('moderators','langues'));
    }

    public function langues()
    {
        
       //
         $langues = Langue :: all();
         return view('dashboard.langues',compact('langues'));
    }

    /**
     * Store a newly created language from admin modal.
     */
    public function storeLangue(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        try {
            Langue::create($data);
            return redirect()->back()->with('success', 'Langue ajoutée.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible d\'enregistrer la langue.']);
        }
    }

    /**
     * Update an existing language.
     */
    public function updateLangue(\Illuminate\Http\Request $request, $id)
    {
        $data = $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        try {
            $langue = Langue::findOrFail($id);
            $langue->update($data);
            return redirect()->back()->with('success', 'Langue modifiée.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible de mettre à jour la langue.']);
        }
    }
    public function destroyLangue($id)
    {
        try {
            $langue = Langue::findOrFail($id);
            $langue->delete();
            return redirect()->back()->with('success', 'Langue supprimée.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible de supprimer la langue.']);
        }
    }

  public function recettes()
{
    try {
        // D'abord, vérifiez ce qui est dans la table
        $allContents = Contenu::all();
        \Log::info('Total contenus dans la table: ' . $allContents->count());
        
        if ($allContents->count() > 0) {
            \Log::info('Premier contenu:', [
                'id' => $allContents->first()->id_contenu,
                'titre' => $allContents->first()->titre,
                'id_type_contenu' => $allContents->first()->id_type_contenu,
                'statut' => $allContents->first()->statut
            ]);
        }
        
        // Maintenant, récupérez les recettes
        $recettes = Contenu::with([
                    'auteur:id_utilisateur,nom,prenom',
                    'moderateur:id_utilisateur,nom,prenom'
                ])
                ->where('id_type_contenu', 1)
                ->where('parent_id', 0)
                ->get();
        
        \Log::info('Recettes trouvées: ' . $recettes->count());
        
        $regions = Region::all();
        $langues = Langue::all();
        $moderateurs = Utilisateurs::where('id_role', 3)->get();
        $auteurs = Utilisateurs::all();

    } catch (\Exception $e) {
        \Log::error('Erreur dans recettes(): ' . $e->getMessage());
        $recettes = collect();
        $regions = collect();
        $langues = collect();
        $moderateurs = collect();
        $auteurs = collect();
    }

    return view('dashboard.recettes', compact('recettes','regions','langues','moderateurs','auteurs'));
}

    public function storeRecette(Request $request)
{
    $data = $request->validate([
        'titre' => 'required|string|max:255',
        'texte' => 'required|string',
        'id_region' => 'required|integer',
        'id_langue' => 'required|integer',
        'id_moderateur' => 'nullable|integer',
        'id_auteur' => 'required|integer',
        'image' => 'nullable|image',
        'video' => 'nullable|mimetypes:video/mp4,video/ogg,video/webm|max:20480'
    ]);

    try {
        // Définition automatique des champs imposés
        $data['statut'] = 'publié';
        $data['parent_id'] = 0;
        $data['id_type_contenu'] = 1;
        $data['date_creation'] = now();

        // Upload image avec Cloudinary
        if ($request->hasFile('image')) {
            $result = $request->file('image')->storeOnCloudinary('culturebenin/recettes');
            $data['image'] = $result->getSecurePath();
        }

        // Upload video avec Cloudinary
        if ($request->hasFile('video')) {
            $result = $request->file('video')->storeOnCloudinary('culturebenin/recettes/videos');
            $data['video'] = $result->getSecurePath();
        }

        Contenu::create($data);

        return redirect()->back()->with('success', 'Recette ajoutée avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Impossible d\'ajouter la recette.']);
    }
}




    public function histoires()
{
    try {
        $histoires = Contenu::with([
                    'auteur:id_utilisateur,nom,prenom',
                    'moderateur:id_utilisateur,nom,prenom'
                ])
                ->whereIn('id_type_contenu', [2,3])
                ->get();

        $auteurs = Utilisateurs::all(); // <--- Ajoute ça
        $moderateurs = Utilisateurs::where('id_role', 3)->get();
        $regions = Region::all();
        $langues = Langue::all();
    } catch (\Exception $e) {
        $histoires = collect();
        $auteurs = collect(); // <--- pour éviter l'erreur
        $moderateurs = collect();
        $regions = collect();
        $langues = collect();
    }

    return view('dashboard.histoires', compact('histoires', 'auteurs', 'moderateurs', 'regions', 'langues'));
}


   

    public function regions()
    {
        // Récupère toutes les régions depuis la table `region`
        try {
            $regions = Region::all();
            $langues = Langue::all();
        } catch (\Exception $e) {
            // En cas d'erreur de connexion / table manquante, on passe un tableau vide
            $regions = [];
            $langues = collect();
        }

        return view('dashboard.regions', compact('regions','langues'));
    }

    /**
     * Store a new utilisateur.
     */
  

    public function storeUtilisateur(Request $request)
{
    $data = $request->validate([
        'nom'=>'required|string|max:255',
        'prenom'=>'required|string|max:255',
        'email'=>'required|email|max:255|unique:utilisateurs,email',
        'mot_de_passe'=>'required|string|min:6',
        'sexe'=>'nullable|string|max:10',
        'date_inscription'=>'nullable|date',
        'date_naissance'=>'nullable|date',
        'statut'=>'nullable|string|max:50',
        'photo'=>'nullable|image|max:2048',
        'id_role'=>'required|integer',
        'id_langue'=>'nullable|integer'
    ]);

    // Handle photo file upload avec Cloudinary
    if ($request->hasFile('photo')) {
        $result = $request->file('photo')->storeOnCloudinary('culturebenin/avatars');
        $data['photo'] = $result->getSecurePath();
    }

    $data['mot_de_passe']=bcrypt($data['mot_de_passe']);
    Utilisateurs::create($data);

    return redirect()->back()->with('success','Utilisateur créé.');
}

    public function updateUtilisateur(Request $request,$id)
{
    $data = $request->validate([
        'nom'=>'required|string|max:255',
        'prenom'=>'required|string|max:255',
        'email'=>"required|email|max:255|unique:utilisateurs,email,$id",
        'mot_de_passe'=>'nullable|string|min:6',
        'sexe'=>'nullable|string|max:10',
        'date_inscription'=>'nullable|date',
        'date_naissance'=>'nullable|date',
        'statut'=>'nullable|string|max:50',
        'photo'=>'nullable|image|max:2048',
        'id_role'=>'required|integer',
        'id_langue'=>'nullable|integer'
    ]);

    $user = utilisateurs::findOrFail($id);
    if(!empty($data['mot_de_passe'])) $data['mot_de_passe']=bcrypt($data['mot_de_passe']);
    else unset($data['mot_de_passe']);

    // Handle photo upload replacement
    if ($request->hasFile('photo')) {
        // delete old photo from public disk if present and if path is storage/...
        if (!empty($user->photo) && str_starts_with($user->photo, 'storage/')) {
            $oldPath = substr($user->photo, strlen('storage/'));
            try { Storage::disk('public')->delete($oldPath); } catch (\Exception $e) { /* ignore */ }
        }
        $path = $request->file('photo')->store('avatars', 'public');
        $data['photo'] = 'storage/' . $path;
    }

    $user->update($data);
    return redirect()->back()->with('success','Utilisateur modifié.');
}


    public function destroyUtilisateur($id)
    {
        try{
            $user = Utilisateurs::findOrFail($id);
                // delete avatar from storage if present
                if(!empty($user->photo) && str_starts_with($user->photo, 'storage/')){
                    $oldPath = substr($user->photo, strlen('storage/'));
                    try{ Storage::disk('public')->delete($oldPath); } catch(\Exception $e) { /* ignore */ }
                }
                $user->delete();
            return redirect()->back()->with('success','Utilisateur supprimé.');
        } catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>'Impossible de supprimer l\'utilisateur.']);
        }
    }

    /**
     * Store a new region.
     */
    public function storeRegion(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'nom_region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|string|max:255',
            'localisation' => 'nullable|string|max:255',
        ]);

        try{
            Region::create($data);
            return redirect()->back()->with('success','Région créée.');
        } catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>'Impossible de créer la région.']);
        }
    }

    /**
     * Update region.
     */
    public function updateRegion(\Illuminate\Http\Request $request, $id)
    {
        $data = $request->validate([
            'nom_region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|string|max:255',
            'localisation' => 'nullable|string|max:255',
        ]);

        try{
            $region = Region::findOrFail($id);
            $region->update($data);
            return redirect()->back()->with('success','Région modifiée.');
        } catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>'Impossible de modifier la région.']);
        }
    }

    public function destroyRegion($id)
    {
        try{
            $region = Region::findOrFail($id);
            $region->delete();
            return redirect()->back()->with('success','Région supprimée.');
        } catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>'Impossible de supprimer la région.']);
        }
    }

    public function motDePasse()
    {
        return view('dashboard.mot-de-passe');
    }

    public function deconnexion()
    {
        return view('dashboard.deconnexion');
    }

    /**
     * Store a newly created histoire (conte).
     */
    public function storeHistoire(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|integer',
            'id_langue' => 'required|integer',
            'id_moderateur' => 'nullable|integer',
            'id_auteur' => 'required|integer',
            'image' => 'nullable|image',
            'video' => 'nullable|mimetypes:video/mp4,video/ogg,video/webm|max:20480'
        ]);

        try {
            // Définition des champs
            $data['statut'] = 'publié';
            $data['parent_id'] = 0;
            $data['id_type_contenu'] = 2; // histoire
            $data['date_creation'] = now();

            // Upload image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('histoires', 'public');
                $data['image'] = 'storage/' . $path;
            }

            // Upload video
            if ($request->hasFile('video')) {
                $path = $request->file('video')->store('histoires/videos', 'public');
                $data['video'] = 'storage/' . $path;
            }

            Contenu::create($data);

            return redirect()->back()->with('success', 'Histoire ajoutée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible d\'ajouter l\'histoire.']);
        }
    }

    /**
     * Return JSON data for a contenu item (for modal view/edit).
     */
    public function showContenu($id)
    {
        try {
            $contenu = Contenu::with(['auteur:id_utilisateur,nom,prenom','moderateur:id_utilisateur,nom,prenom'])->findOrFail($id);
            return response()->json($contenu);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Contenu introuvable.'], 404);
        }
    }

    /**
     * Update a contenu item.
     */
    public function updateContenu(Request $request, $id)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|integer',
            'id_langue' => 'required|integer',
            'id_moderateur' => 'nullable|integer',
            'id_auteur' => 'required|integer',
            'image' => 'nullable|image',
            'video' => 'nullable|mimetypes:video/mp4,video/ogg,video/webm|max:20480'
        ]);

        try {
            $contenu = Contenu::findOrFail($id);

            // Handle image replacement
            if ($request->hasFile('image')) {
                // delete old image
                if (!empty($contenu->image) && str_starts_with($contenu->image, 'storage/')) {
                    $oldPath = substr($contenu->image, strlen('storage/'));
                    try { Storage::disk('public')->delete($oldPath); } catch (\Exception $e) { /* ignore */ }
                }
                $path = $request->file('image')->store('contenu', 'public');
                $data['image'] = 'storage/' . $path;
            }

            if ($request->hasFile('video')) {
                if (!empty($contenu->video) && str_starts_with($contenu->video, 'storage/')) {
                    $oldPath = substr($contenu->video, strlen('storage/'));
                    try { Storage::disk('public')->delete($oldPath); } catch (\Exception $e) { /* ignore */ }
                }
                $path = $request->file('video')->store('contenu/videos', 'public');
                $data['video'] = 'storage/' . $path;
            }

            $contenu->update($data);
            return redirect()->back()->with('success', 'Contenu modifié.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible de modifier le contenu.']);
        }
    }

    /**
     * Delete a contenu item.
     */
    public function destroyContenu($id)
    {
        try {
            $contenu = Contenu::findOrFail($id);
            // delete media files from storage
            if(!empty($contenu->image) && str_starts_with($contenu->image, 'storage/')){
                $oldPath = substr($contenu->image, strlen('storage/'));
                try { Storage::disk('public')->delete($oldPath); } catch (\Exception $e) { /* ignore */ }
            }
            if(!empty($contenu->video) && str_starts_with($contenu->video, 'storage/')){
                $oldPath = substr($contenu->video, strlen('storage/'));
                try { Storage::disk('public')->delete($oldPath); } catch (\Exception $e) { /* ignore */ }
            }
            $contenu->delete();
            return redirect()->back()->with('success', 'Contenu supprimé.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Impossible de supprimer le contenu.']);
        }
    }
}