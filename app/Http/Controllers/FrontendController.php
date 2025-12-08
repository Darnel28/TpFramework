<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\utilisateurs;
use App\Models\Commentaire;

class FrontendController extends Controller
{
    /**
     * Show the home page
     */
    public function home()
    {
        // Vérifiez d'abord ce que contient la table
        $totalContenus = Contenu::count();
        
        // S'il n'y a pas de colonne 'rating', utilisez autre chose pour le contenu principal
        $featured = Contenu::where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->first();
        
        // Actu & Tendances (3 contenus secondaires)
        $tendances = Contenu::where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->skip(1) // Sauter le premier qu'on a déjà
            ->take(3)
            ->get();

        // Explorer Plus : contenus les plus récents (6 suivants)
        $recents = Contenu::where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->skip(4) // Sauter les 4 premiers (featured + 3 tendances)
            ->take(6)
            ->get();

        // Équipe de modération (rôle = 3)
        $moderateurs = utilisateurs::where('id_role', 3)
            ->select('id_utilisateur', 'nom', 'prenom', 'photo', 'email')
            ->orderBy('nom')
            ->get();

        // Pour le débogage, passez aussi le total
        return view('frontend.home', compact('featured', 'tendances', 'recents', 'totalContenus', 'moderateurs'));
    }

    /**
     * Show the contenus page
     */
     public function contenus(Request $request)
    {
        // Récupérer les paramètres de filtrage
        $query = Contenu::where('statut', 'publié')
            ->with(['region', 'langue', 'commentaires']);
        
        // Filtre par région
        if ($request->filled('region')) {
            $query->where('id_region', $request->region);
        }
        
        // Filtre par langue
        if ($request->filled('langue')) {
            $query->where('id_langue', $request->langue);
        }
        
        // Filtre par date (plus récent)
        if ($request->filled('date')) {
            if ($request->date === 'recent') {
                $query->orderBy('date_creation', 'desc');
            } elseif ($request->date === 'ancien') {
                $query->orderBy('date_creation', 'asc');
            }
        } else {
            $query->orderBy('date_creation', 'desc');
        }
        
        // Filtre par popularité (nombre de commentaires)
        if ($request->filled('popularite')) {
            if ($request->popularite === 'populaire') {
                $query->withCount('commentaires')->orderBy('commentaires_count', 'desc');
            }
        }
        
        // Recherche par mot-clé
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('texte', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Pagination
        $contents = $query->paginate(12);
        
        // Récupérer les régions et langues pour les filtres
        $regions = Region::all();
        $langues = Langue::all();
        
        // Contenus les plus populaires (pour le slider)
        $popularContents = Contenu::where('statut', 'publié')
            ->withCount('commentaires')
            ->orderBy('commentaires_count', 'desc')
            ->take(6)
            ->get();
        
        // Contenus les plus récents (pour "dernières minutes")
        $recentContents = Contenu::where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->take(3)
            ->get();

        return view('frontend.contenus', compact('contents', 'regions', 'langues', 'popularContents', 'recentContents', 'request'));
    }

    /**
     * Show the langues page
     */
   public function langues()
{
    // Récupérer toutes les langues avec leurs contenus
    $langues = Langue::withCount(['contenus' => function($query) {
        $query->where('statut', 'publié');
    }])->get();
    
    // Préparer les données
    $langues = $langues->map(function($langue) {
        return (object)[
            'id_langue' => $langue->id_langue,
            'nom_langue' => $langue->nom_langue,
            'description' => $langue->description ?? 'Langue parlée au Bénin.',
            'contents_count' => $langue->contenus_count,
            'filter_category' => $this->getLanguageCategory($langue->nom_langue),
            'type' => $this->getLanguageType($langue->nom_langue),
            'color' => $this->getLanguageColor($langue->nom_langue),
            'icon' => $this->getLanguageIcon($langue->nom_langue),
            'region_count' => $langue->contenus()->distinct('id_region')->count(),
            'speakers' => $this->getEstimatedSpeakers($langue->nom_langue),
            'family' => $this->getLanguageFamily($langue->nom_langue),
        ];
    });

    // Statistiques
    $totalContents = $langues->sum('contents_count');
    $mostUsedRegion = $langues->max('region_count') ?? 0;
    
    // Stats pour les familles linguistiques
    $familyStats = [
        'niger_congo' => $langues->where('family', 'like', '%Niger-Congo%')->count(),
        'volta_congo' => $langues->where('family', 'like', '%Volta-Congo%')->count(),
        'gur' => $langues->where('family', 'like', '%Gur%')->count(),
        'kwa' => $langues->where('family', 'like', '%Kwa%')->count(),
    ];
    
    // Stats par région
    $regionStats = [
        'nord' => 30,
        'sud' => 40,
        'centre' => 20,
        'ouest' => 10,
    ];

    return view('frontend.langues', compact('langues', 'totalContents', 'mostUsedRegion', 'familyStats', 'regionStats'));
}

// Méthodes helper pour les langues
private function getLanguageCategory($langueName)
{
    $officialLanguages = ['Français', 'Anglais'];
    $regionalLanguages = ['Fon', 'Yoruba', 'Bariba', 'Dendi'];
    
    if (in_array($langueName, $officialLanguages)) {
        return 'filter-officielle';
    } elseif (in_array($langueName, $regionalLanguages)) {
        return 'filter-regionale';
    } else {
        return 'filter-locale';
    }
}

private function getLanguageType($langueName)
{
    $types = [
        'Français' => 'Officielle',
        'Anglais' => 'Officielle',
        'Fon' => 'Nationale',
        'Yoruba' => 'Transfrontalière',
        'Bariba' => 'Régionale',
        'Dendi' => 'Régionale',
        'Adja' => 'Locale',
        'Mina' => 'Locale',
        'Goun' => 'Locale',
    ];
    
    return $types[$langueName] ?? 'Locale';
}

private function getLanguageColor($langueName)
{
    $colors = [
        'Français' => '#3498db',
        'Anglais' => '#e74c3c',
        'Fon' => '#2ecc71',
        'Yoruba' => '#f39c12',
        'Bariba' => '#9b59b6',
        'Dendi' => '#1abc9c',
        'Adja' => '#e67e22',
        'Mina' => '#34495e',
        'Goun' => '#d35400',
    ];
    
    return $colors[$langueName] ?? '#667eea';
}

private function getLanguageIcon($langueName)
{
    $icons = [
        'Français' => 'bi bi-translate',
        'Anglais' => 'bi bi-globe',
        'Fon' => 'bi bi-chat-left-text',
        'Yoruba' => 'bi bi-megaphone',
        'Bariba' => 'bi bi-book',
        'Dendi' => 'bi bi-mic',
        'Adja' => 'bi bi-people',
        'Mina' => 'bi bi-volume-up',
        'Goun' => 'bi bi-chat-square-text',
    ];
    
    return $icons[$langueName] ?? 'bi bi-translate';
}

private function getEstimatedSpeakers($langueName)
{
    $speakers = [
        'Français' => '10M+',
        'Fon' => '2.1M',
        'Yoruba' => '1.7M',
        'Bariba' => '1.2M',
        'Dendi' => '300K',
        'Adja' => '600K',
        'Mina' => '400K',
        'Goun' => '700K',
    ];
    
    return $speakers[$langueName] ?? 'Plusieurs milliers';
}

private function getLanguageFamily($langueName)
{
    $families = [
        'Français' => 'Indo-Européenne',
        'Anglais' => 'Indo-Européenne',
        'Fon' => 'Niger-Congo, Volta-Congo, Kwa',
        'Yoruba' => 'Niger-Congo, Volta-Congo, Yoruboid',
        'Bariba' => 'Niger-Congo, Gur',
        'Dendi' => 'Nilo-Saharienne',
        'Adja' => 'Niger-Congo, Kwa',
        'Mina' => 'Niger-Congo, Kwa',
        'Goun' => 'Niger-Congo, Kwa',
    ];
    
    return $families[$langueName] ?? 'Niger-Congo';
}

/**
 * Show language details page
 */
public function langueDetails($id)
{
    $langue = Langue::with(['contenus' => function($query) {
        $query->where('statut', 'publié')
              ->with(['region', 'commentaires'])
              ->orderBy('date_creation', 'desc');
    }])->findOrFail($id);
    
    // Statistiques
    $langue->total_contents = $langue->contenus->count();
    $langue->total_comments = $langue->contenus->sum(function($contenu) {
        return $contenu->commentaires->count();
    });
    
    // Régions où la langue est parlée
    $regions = $langue->contenus->groupBy('id_region')->map(function($contents, $regionId) {
        $region = Region::find($regionId);
        return [
            'name' => $region ? $region->nom_region : 'Inconnue',
            'count' => $contents->count(),
            'percentage' => round(($contents->count() / $langue->total_contents) * 100, 1)
        ];
    })->values()->sortByDesc('count');
    
    // Contenus récents
    $recentContents = $langue->contenus->take(5);
    
    // Contenus populaires
    $popularContents = $langue->contenus->sortByDesc(function($contenu) {
        return $contenu->commentaires->count();
    })->take(5);

    return view('frontend.languesdetail', compact('langue', 'regions', 'recentContents', 'popularContents'));
}

 public function regions()
    {
        // Récupérer toutes les régions avec leurs contenus
        $regions = Region::withCount(['contenus' => function($query) {
            $query->where('statut', 'publié');
        }])->orderBy('nom_region')->get();
        
        // Transformer en tableau associatif simple
        $regionsArray = $regions->map(function($region) {
            return [
                'id' => $region->id_region,
                'nom_region' => $region->nom_region,
                'description' => $region->description ?? 'Explorez la richesse culturelle de cette région.',
                'contenus_count' => $region->contenus_count,
                'zone' => $this->getRegionZone($region->nom_region),
                'chef_lieu' => $this->getChefLieu($region->nom_region),
                'icon' => $this->getRegionIcon($region->nom_region),
                'color' => $this->getRegionColor($region->nom_region),
            ];
        })->toArray();

        // Calculer les statistiques
        $totalContents = array_sum(array_column($regionsArray, 'contenus_count'));
        
        // Trouver la région avec le plus de contenus
        $maxContents = max(array_column($regionsArray, 'contenus_count'));
        $mostContentRegion = collect($regionsArray)
            ->where('contenus_count', $maxContents)
            ->first();

        return view('frontend.regions', [
            'regions' => $regionsArray,
            'totalContents' => $totalContents,
            'mostContentRegion' => $mostContentRegion
        ]);
    }

    /**
     * Determine region zone (nord, sud, centre, ouest)
     */
    private function getRegionZone($regionName)
    {
        $zones = [
            'Atacora' => 'nord',
            'Donga' => 'nord',
            'Borgou' => 'nord',
            'Alibori' => 'nord',
            'Atlantique' => 'sud',
            'Littoral' => 'sud',
            'Ouémé' => 'sud',
            'Plateau' => 'sud',
            'Collines' => 'centre',
            'Zou' => 'centre',
            'Couffo' => 'ouest',
            'Mono' => 'ouest'
        ];
        
        return $zones[$regionName] ?? 'centre';
    }

    /**
     * Get region capital
     */
    private function getChefLieu($regionName)
    {
        $chefsLieux = [
            'Atacora' => 'Natitingou',
            'Donga' => 'Djougou',
            'Borgou' => 'Parakou',
            'Alibori' => 'Kandi',
            'Atlantique' => 'Allada',
            'Littoral' => 'Cotonou',
            'Ouémé' => 'Porto-Novo',
            'Plateau' => 'Sakété',
            'Collines' => 'Dassa-Zoumé',
            'Zou' => 'Abomey',
            'Couffo' => 'Aplahoué',
            'Mono' => 'Lokossa'
        ];
        
        return $chefsLieux[$regionName] ?? 'Non spécifié';
    }

    /**
     * Get icon for region
     */
    private function getRegionIcon($regionName)
    {
        $icons = [
            'Atacora' => 'bi bi-mountains',
            'Donga' => 'bi bi-tree',
            'Borgou' => 'bi bi-building',
            'Alibori' => 'bi bi-seed',
            'Atlantique' => 'bi bi-water',
            'Littoral' => 'bi bi-buildings',
            'Ouémé' => 'bi bi-river',
            'Plateau' => 'bi bi-geo-alt',
            'Collines' => 'bi bi-geo',
            'Zou' => 'bi bi-museum',
            'Couffo' => 'bi bi-house',
            'Mono' => 'bi bi-droplet'
        ];
        
        return $icons[$regionName] ?? 'bi bi-geo-alt';
    }

    /**
     * Get color for region
     */
    private function getRegionColor($regionName)
    {
        $colors = [
            'Atacora' => '#8B4513', // Vert forêt
            'Donga' => '#8B45132', // Vert
            'Borgou' => '#8B4513', // Rouge
            'Alibori' => '#8B4513', // Orange
            'Atlantique' => '#8B4513', // Bleu
            'Littoral' => '#8B4513', // Violet
            'Ouémé' => '#8B4513', // Turquoise
            'Plateau' => '#8B4513', // Vert clair
            'Collines' => '#8B4513', // Orange rouge
            'Zou' => '#8B4513', // Violet foncé
            'Couffo' => '#8B4513', // Marron
            'Mono' => '#00CED1' // Cyan
        ];
        
        return $colors[$regionName] ?? '#0ea2bd';
    }

    public function regionDetails($id)
{
    $region = Region::with(['contenus' => function($query) {
        $query->where('statut', 'publié')
              ->with(['langue', 'commentaires'])
              ->orderBy('date_creation', 'desc');
    }])->findOrFail($id);
    
    // Ajouter des informations supplémentaires
    $region->zone = $this->getRegionZone($region->nom_region);
    $region->chef_lieu = $this->getChefLieu($region->nom_region);
    $region->icon = $this->getRegionIcon($region->nom_region);
    $region->color = $this->getRegionColor($region->nom_region);
    
    // Statistiques
    $region->total_contents = $region->contenus->count();
    $region->total_comments = $region->contenus->sum(function($contenu) {
        return $contenu->commentaires->count();
    });
    
    // Langues de la région - CORRECTION ICI
    $languages = $region->contenus->groupBy('id_langue')->map(function($contents, $langId) use ($region) {
        $langue = Langue::find($langId);
        return [
            'name' => $langue ? $langue->nom_langue : 'Inconnue',
            'count' => $contents->count(),
            'percentage' => $region->total_contents > 0 
                ? round(($contents->count() / $region->total_contents) * 100, 1)
                : 0
        ];
    })->values()->sortByDesc('count');
    
    // Contenus récents
    $recentContents = $region->contenus->take(5);
    
    // Contenus populaires
    $popularContents = $region->contenus->sortByDesc(function($contenu) {
        return $contenu->commentaires->count();
    })->take(5);

    return view('frontend.regionsdetail', compact('region', 'languages', 'recentContents', 'popularContents'));
}
   
    

    private function getRegionFilterCategory($regionName)
    {
        $northernRegions = ['Atacora', 'Donga', 'Borgou', 'Alibori'];
        $southernRegions = ['Atlantique', 'Littoral', 'Ouémé', 'Plateau'];
        $centralRegions = ['Collines', 'Zou', 'Couffo'];
        $easternRegions = ['Borgou']; // Exemple
        $westernRegions = ['Mono', 'Couffo'];
        
        if (in_array($regionName, $northernRegions)) {
            return 'filter-mountain';
        } elseif (in_array($regionName, $southernRegions)) {
            return 'filter-tropical';
        } elseif (in_array($regionName, $centralRegions)) {
            return 'filter-urban';
        } elseif (in_array($regionName, $easternRegions)) {
            return 'filter-historical';
        } elseif (in_array($regionName, $westernRegions)) {
            return 'filter-coastal';
        }
        
        return 'filter-tropical'; // Default
    }
    
    /**
     * Get region type badge
     */
    private function getRegionType($regionName)
    {
        $types = [
            'Atacora' => 'Montagneuse',
            'Donga' => 'Savane',
            'Borgou' => 'Historique',
            'Alibori' => 'Agricole',
            'Atlantique' => 'Côtière',
            'Littoral' => 'Urbaine',
            'Ouémé' => 'Fluviale',
            'Plateau' => 'Côtière',
            'Collines' => 'Vallonnée',
            'Zou' => 'Culturelle',
            'Couffo' => 'Rurale',
            'Mono' => 'Lacustre'
        ];
        
        return $types[$regionName] ?? 'Culturelle';
    }

    /**
     * Show About page
     */
    public function about()
    {
        return view('frontend.àpropos');
    }

    /**
     * Show Contact page
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Page Découvrir avec effet 3D
     */
    public function decouvrir()
    {
        $contenus = Contenu::with(['region', 'langue'])
            ->where('statut', 'publié')
            ->inRandomOrder()
            ->take(10)
            ->get();
        
        // Si aucun contenu trouvé, créer des contenus exemple avec images d'internet
        if ($contenus->isEmpty()) {
            $contenus = collect([
                (object)[
                    'id_contenu' => 1,
                    'titre' => 'Palais Royal d\'Abomey',
                    'texte' => 'Découvrez l\'histoire fascinante des rois du Dahomey et leur patrimoine architectural unique classé au patrimoine mondial de l\'UNESCO.',
                    'image' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?w=1920',
                    'region' => (object)['nom_region' => 'Zou'],
                    'langue' => (object)['nom_langue' => 'Fon']
                ],
                (object)[
                    'id_contenu' => 2,
                    'titre' => 'Cité Lacustre de Ganvié',
                    'texte' => 'Explorez le plus grand village lacustre d\'Afrique, construit sur pilotis au cœur du lac Nokoué, un exemple unique d\'adaptation humaine.',
                    'image' => 'https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=1920',
                    'region' => (object)['nom_region' => 'Atlantique'],
                    'langue' => (object)['nom_langue' => 'Toffin']
                ],
                (object)[
                    'id_contenu' => 3,
                    'titre' => 'Parc National de la Pendjari',
                    'texte' => 'Partez à la rencontre de la faune sauvage africaine : éléphants, lions, buffles dans l\'un des derniers sanctuaires naturels d\'Afrique de l\'Ouest.',
                    'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920',
                    'region' => (object)['nom_region' => 'Atacora'],
                    'langue' => (object)['nom_langue' => 'Bariba']
                ],
                (object)[
                    'id_contenu' => 4,
                    'titre' => 'Plage de Fidjrossè',
                    'texte' => 'Profitez des magnifiques plages de sable doré de Cotonou, bordées de cocotiers et baignées par l\'océan Atlantique.',
                    'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920',
                    'region' => (object)['nom_region' => 'Littoral'],
                    'langue' => (object)['nom_langue' => 'Français']
                ],
                (object)[
                    'id_contenu' => 5,
                    'titre' => 'Marché Dantokpa',
                    'texte' => 'Plongez dans l\'ambiance colorée du plus grand marché à ciel ouvert d\'Afrique de l\'Ouest, véritable cœur économique du Bénin.',
                    'image' => 'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?w=1920',
                    'region' => (object)['nom_region' => 'Littoral'],
                    'langue' => (object)['nom_langue' => 'Fon']
                ],
                (object)[
                    'id_contenu' => 6,
                    'titre' => 'Temple des Pythons',
                    'texte' => 'Visitez ce temple sacré de Ouidah où les pythons royaux sont vénérés selon les traditions vodoun ancestrales.',
                    'image' => 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=1920',
                    'region' => (object)['nom_region' => 'Atlantique'],
                    'langue' => (object)['nom_langue' => 'Fon']
                ],
                (object)[
                    'id_contenu' => 7,
                    'titre' => 'Chutes de Tanougou',
                    'texte' => 'Rafraîchissez-vous dans les eaux cristallines de ces cascades majestueuses nichées dans les montagnes de l\'Atacora.',
                    'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=1920',
                    'region' => (object)['nom_region' => 'Atacora'],
                    'langue' => (object)['nom_langue' => 'Waama']
                ],
                (object)[
                    'id_contenu' => 8,
                    'titre' => 'Porte du Non-Retour',
                    'texte' => 'Recueillez-vous devant ce monument poignant qui commémore les millions d\'Africains déportés durant la traite négrière.',
                    'image' => 'https://images.unsplash.com/photo-1508020963102-c6c723be5764?w=1920',
                    'region' => (object)['nom_region' => 'Atlantique'],
                    'langue' => (object)['nom_langue' => 'Français']
                ],
                (object)[
                    'id_contenu' => 9,
                    'titre' => 'Tata Somba',
                    'texte' => 'Admirez l\'architecture unique de ces maisons-forteresses traditionnelles, symboles de l\'ingéniosité du peuple Somba.',
                    'image' => 'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=1920',
                    'region' => (object)['nom_region' => 'Atacora'],
                    'langue' => (object)['nom_langue' => 'Ditammari']
                ],
                (object)[
                    'id_contenu' => 10,
                    'titre' => 'Fête du Vodoun',
                    'texte' => 'Immergez-vous dans les célébrations mystiques et colorées de la fête nationale du Vodoun, religion ancestrale du Bénin.',
                    'image' => 'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?w=1920',
                    'region' => (object)['nom_region' => 'Ouémé'],
                    'langue' => (object)['nom_langue' => 'Fon']
                ],
            ]);
        }
        
        return view('frontend.decouvrir', compact('contenus'));
    }

    /**
     * Blog listing
     */
    public function blog()
    {
        return view('frontend.blog');
    }

    /**
     * Show a single content details page
     */


    /**
     * Show a single content details page
     */
    public function contentDetails($id)
    {
        // Si l'utilisateur est admin (2) ou moderateur (3), lui permettre de voir le contenu quel que soit le statut
        $isPrivileged = auth()->check() && in_array((auth()->user()->id_role ?? null), [2,3]);

        $query = Contenu::with(['region', 'langue', 'auteur', 'moderateur', 'commentaires.utilisateur']);

        if (! $isPrivileged) {
            $query->where('statut', 'publié');
        }

        $content = $query->findOrFail($id);

        // Suggestions de contenus similaires (si public, seuls les publiés; si modérateur/admin, inclure tous)
        $similarQuery = Contenu::where('id_contenu', '!=', $id)
            ->where(function($q) use ($content) {
                if ($content->id_region) {
                    $q->orWhere('id_region', $content->id_region);
                }
                if ($content->id_langue) {
                    $q->orWhere('id_langue', $content->id_langue);
                }
            });

        if (! $isPrivileged) {
            $similarQuery->where('statut', 'publié');
        }

        $similarContents = $similarQuery->with(['region', 'commentaires'])
            ->orderBy('date_creation', 'desc')
            ->take(3)
            ->get();

        // Paywall: si le contenu est long, demander paiement de 100 XOF pour voir la suite
        $text = strip_tags($content->texte ?? '');
        $wordCount = str_word_count($text);
        $threshold = 200; // nombre de mots autorisés avant paywall

        $paidContents = session('paid_contents', []);
        $hasPaid = in_array($id, $paidContents);

        $restricted = false;
        $excerpt = null;
        if (! $isPrivileged && $wordCount > $threshold && ! $hasPaid) {
            $restricted = true;
            // extrait pour aperçu (limite en caractères)
            $excerpt = \Illuminate\Support\Str::limit($text, 800);
        }

        return view('frontend.contenusdetails', compact('content', 'similarContents', 'restricted', 'excerpt'));
    }

    /**
     * Handle comment submission
     */
    public function postComment(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|min:5|max:1000',
        ]);

        $comment = new Commentaire();

        // Assigner l'utilisateur si connecté, sinon laisser null
        $comment->id_utilisateur = auth()->check() ? auth()->id() : null;

        // Attribuer le contenu, le texte et la date (colonne `date` dans la table)
        $comment->id_contenu = $id;
        $comment->texte = $request->message;
        $comment->date = now();

        // note optionnelle (laissez null par défaut)
        if ($request->filled('note')) {
            $comment->note = (int) $request->note;
        }

        $comment->save();

        return redirect()
            ->route('content.details', $id)
            ->with('success', 'Votre commentaire a été posté avec succès !');
    }

  


    /**
     * Contribute page
     */
    public function contribute()
    {
        $regions = Region::all();
        $langues = Langue::all();
        // Récupérer contenus originaux (parent_id = 0) pour les traductions
        $originals = Contenu::where('parent_id', 0)
            ->where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->get();

        // Récupérer les types de contenu depuis la table `typecontenu`
        try {
            $typecontenus = \App\Models\TypeContenu::orderBy('nom_contenu')->get();
        } catch (\Throwable $e) {
            $typecontenus = collect();
        }

        return view('frontend.contribuer', compact('regions', 'langues', 'originals', 'typecontenus'));
    }
  
public function subscribeNewsletter(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:newsletter_subscriptions,email'
    ]);
    
    // Vous devrez créer un modèle NewsletterSubscription
    // NewsletterSubscription::create(['email' => $request->email]);
    
    return back()->with('success', 'Merci pour votre inscription à notre newsletter!');
}
public function verifierAcces(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    // Vérifier les identifiants
    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Connexion réussie
        $request->session()->regenerate();
            // Rediriger selon le rôle
            $user = Auth::user();
            $role = $user->id_role ?? null;

            if ($role == 2) {
                $redirect = route('admin.accueil');
            } elseif ($role == 3) {
                $redirect = route('moderateur.accueil');
            } else {
                $redirect = route('contribute');
            }

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie !',
                'redirect' => $redirect
            ]);
    }
    
    // Vérifier si l'email existe
    $userExists = Utilisateurs::where('email', $request->email)->exists();
    
    if (!$userExists) {
        // Email non trouvé, proposer l'inscription
        return response()->json([
            'success' => false,
            'type' => 'not_registered',
            'message' => 'Cet email n\'est pas encore enregistré. Voulez-vous créer un compte ?'
        ]);
    } else {
        // Mot de passe incorrect
        return response()->json([
            'success' => false,
            'type' => 'wrong_password',
            'message' => 'Mot de passe incorrect. Veuillez réessayer.'
        ]);
    }
}
 
    /**
     * Payment confirmation page
     */
    public function paymentConfirmation(Request $request)
    {
        $contentId = $request->get('content_id');
        
        if (!$contentId) {
            return redirect()->route('home')->with('error', 'ID de contenu manquant.');
        }
        
        // Vérifier que le contenu existe
        $content = Contenu::find($contentId);
        if (!$content) {
            return redirect()->route('home')->with('error', 'Contenu non trouvé.');
        }
        
        return view('frontend.payment-confirmation', compact('contentId', 'content'));
    }


}