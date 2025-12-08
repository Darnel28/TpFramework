<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\PaymentController;



// Page d'accueil publique (frontend)
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/contenus', [FrontendController::class, 'contenus'])->name('contenus');
Route::get('/langues', [FrontendController::class, 'langues'])->name('langues');
Route::get('/regions', [FrontendController::class, 'regions'])->name('regions');
Route::get('/contribuer', [FrontendController::class, 'contribute'])->name('contribute');
Route::get('/contenus/{id}', [FrontendController::class, 'contentDetails'])->name('content.details');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/a-propos', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/decouvrir', [FrontendController::class, 'decouvrir'])->name('decouvrir');
Route::post('/newsletter/subscribe', [FrontendController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
// Routes pour les contenus
// Alias sans collision de nom pour la même action
Route::get('/contenu/{id}', [FrontendController::class, 'contentDetails'])->name('contenu.details');
Route::post('/contenu/{id}/comment', [FrontendController::class, 'postComment'])->name('content.comment');
Route::get('/region/{id}', [FrontendController::class, 'regionDetails'])->name('region.details');
// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route de contribution (dans FrontendController)
Route::get('/contribuer', [FrontendController::class, 'contribute'])->name('contribute');

// Route pour soumettre une contribution (créer un nouveau contrôleur ou ajouter à FrontendController)
Route::post('/contribuer/soumettre', [ContenuController::class, 'store'])->name('contribute.submit');
Route::post('contribute/very', [FrontendController::class, 'verifierAcces'])->name('contribute.verify');
Route::get('/pay', [PaymentController::class, 'pay'])->name('fedapay.pay');
Route::get('/payment-confirmation', [FrontendController::class, 'paymentConfirmation'])->name('payment.confirmation');
// FedaPay callback peut être GET (redirect du navigateur) ou POST (webhook serveur)
Route::match(['get', 'post'], '/fedapay/callback', [PaymentController::class, 'callback'])->name('fedapay.callback');


// Routes protégées par auth
Route::middleware(['auth',IsAdmin::class ])->group(function () {
   

    // Tableau de bord admin avec prefix 'admin'
    Route::prefix('admin')->group(function () {

        // Accueil dashboard
        Route::get('/accueil', [DashboardController::class, 'index'])->name('admin.accueil');
        Route::post('/contribuer/soumettre', [ContenuController::class, 'store'])->name('admin.contribute.submit');

        // Utilisateurs
        Route::get('/utilisateurs', [DashboardController::class, 'utilisateurs'])->name('admin.utilisateurs');
        Route::post('/utilisateurs', [DashboardController::class, 'storeUtilisateur'])->name('admin.utilisateurs.store');
        Route::put('/utilisateurs/{id}', [DashboardController::class, 'updateUtilisateur'])->name('admin.utilisateurs.update');
        Route::delete('/utilisateurs/{id}', [DashboardController::class, 'destroyUtilisateur'])->name('admin.utilisateurs.destroy');
        // Routes pour les langues
        Route::get('/langues', [FrontendController::class, 'langues'])->name('langues');
        Route::get('/langue/{id}', [FrontendController::class, 'langueDetails'])->name('langue.details');

        // Modérateurs
        Route::get('/moderateurs', [DashboardController::class, 'moderateurs'])->name('admin.moderateurs');

        // Langues
        Route::get('/langues', [DashboardController::class, 'langues'])->name('admin.langues');
        Route::post('/langues', [DashboardController::class, 'storeLangue'])->name('admin.langues.store');
        Route::put('/langues/{id}', [DashboardController::class, 'updateLangue'])->name('admin.langues.update');
        Route::delete('/langues/{id}', [DashboardController::class, 'destroyLangue'])->name('admin.langues.destroy');


        // Recettes
        Route::get('/recettes', [DashboardController::class, 'recettes'])->name('admin.recettes');
        Route::post('/recettes', [DashboardController::class, 'storeRecette'])->name('admin.recettes.store');

        // Histoires
        Route::get('/histoires', [DashboardController::class, 'histoires'])->name('admin.histoires');
        Route::post('/histoires', [DashboardController::class, 'storeHistoire'])->name('admin.histoires.store');

        // Contenu CRUD (view/edit/delete)
        Route::get('/contenu/{id}', [DashboardController::class, 'showContenu'])->name('admin.contenu.show');
        Route::put('/contenu/{id}', [DashboardController::class, 'updateContenu'])->name('admin.contenu.update');
        Route::delete('/contenu/{id}', [DashboardController::class, 'destroyContenu'])->name('admin.contenu.destroy');

        // Régions
        Route::get('/regions', [DashboardController::class, 'regions'])->name('admin.regions');
        Route::post('/regions', [DashboardController::class, 'storeRegion'])->name('admin.regions.store');
        Route::put('/regions/{id}', [DashboardController::class, 'updateRegion'])->name('admin.regions.update');
        Route::delete('/regions/{id}', [DashboardController::class, 'destroyRegion'])->name('admin.regions.destroy');

        // Mot de passe et déconnexion (vue uniquement)
        Route::get('/mot-de-passe', [DashboardController::class, 'motDePasse'])->name('admin.mot-de-passe');
        Route::get('/deconnexion', [DashboardController::class, 'deconnexion'])->name('admin.deconnexion');
    });

    // Profile utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Routes modérateur (auth uniquement, vérification de rôle dans le controller)
Route::middleware(['auth'])->group(function () {
    Route::prefix('moderateur')->group(function () {
        Route::get('/accueil', [\App\Http\Controllers\ModeratorController::class, 'index'])->name('moderateur.accueil');
        Route::get('/contenus', [\App\Http\Controllers\ModeratorController::class, 'contenus'])->name('moderateur.contenus');
        Route::post('/contenu/{id}/approve', [\App\Http\Controllers\ModeratorController::class, 'approve'])->name('moderateur.contenu.approve');
        Route::delete('/contenu/{id}', [\App\Http\Controllers\ModeratorController::class, 'destroy'])->name('moderateur.contenu.destroy');
    });
});


require __DIR__.'/auth.php';

// Route temporaire pour créer un utilisateur de test
Route::get('/create-test-user', function () {
    try {
        // Créer ou mettre à jour le rôle
        DB::table('role')->updateOrInsert(
            ['id_role' => 2],
            ['nom_role' => 'contributeur']
        );

        // Créer ou mettre à jour la langue
        DB::table('langue')->updateOrInsert(
            ['id_langue' => 1],
            ['nom_langue' => 'Français', 'code_langue' => 'fr']
        );

        // Créer l'utilisateur
        $user = \App\Models\Utilisateurs::updateOrCreate(
            ['email' => 'morgane.deguenon@example.com'],
            [
                'nom' => 'DEGUENON',
                'prenom' => 'Morgane',
                'mot_de_passe' => bcrypt('password123'),
                'sexe' => 'F',
                'date_inscription' => now(),
                'date_naissance' => '1995-06-20',
                'statut' => 'actif',
                'id_role' => 2,
                'id_langue' => 1,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});


