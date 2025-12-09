<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeContenu;
use App\Models\Contenu;
use App\Models\Utilisateurs;
use App\Models\Region;
use App\Models\Langue;
use Carbon\Carbon;

class Contenuseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs nécessaires
        $auteur = Utilisateurs::first();
        $regionAtacora = Region::where('nom_region', 'Atacora')->first();
        $regionAtlantique = Region::where('nom_region', 'Atlantique')->first();
        $langueFr = Langue::where('code_langue', 'fr')->first();
        $typeArticle = TypeContenu::where('nom_contenu', 'Article')->first();
        $typeLegende = TypeContenu::where('nom_contenu', 'Légende')->first();
        $typePatrimoine = TypeContenu::where('nom_contenu', 'Patrimoine')->first();

        // Créer les contenus avec des images Unsplash
        $contenus = [
            [
                'titre' => 'Les Tata Somba : Architecture traditionnelle de l\'Atacora',
                'texte' => 'Les Tata Somba sont des habitations fortifiées traditionnelles du peuple Betammaribé dans la région de l\'Atacora. Ces constructions en terre sont inscrites au patrimoine mondial de l\'UNESCO depuis 2004. Elles représentent un exemple remarquable d\'architecture vernaculaire africaine, alliant défense, habitat et spiritualité.',
                'image' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800',
                'date_creation' => Carbon::now()->subDays(10),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(5),
                'id_region' => $regionAtacora->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typePatrimoine->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'La Porte du Non-Retour : Mémoire de l\'esclavage à Ouidah',
                'texte' => 'La Porte du Non-Retour à Ouidah symbolise le dernier point de départ des esclaves africains vers les Amériques. Ce monument commémoratif, érigé en 1995, rappelle la tragédie de la traite négrière. Chaque année, des milliers de visiteurs s\'y recueillent pour honorer la mémoire des millions d\'Africains déportés.',
                'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800',
                'date_creation' => Carbon::now()->subDays(8),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(3),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typePatrimoine->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Le roi Béhanzin et la résistance au colonialisme',
                'texte' => 'Béhanzin, dernier roi indépendant du Dahomey (1889-1894), a mené une résistance acharnée contre la colonisation française. Surnommé "le requin qui trouble les eaux de la barre", il incarne la lutte pour la souveraineté africaine. Capturé en 1894, il fut exilé en Martinique puis en Algérie, où il mourut en 1906.',
                'image' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?w=800',
                'date_creation' => Carbon::now()->subDays(6),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(2),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeArticle->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Légende de Mami Wata : La sirène sacrée',
                'texte' => 'Mami Wata est une divinité aquatique vénérée au Bénin et dans toute l\'Afrique de l\'Ouest. Mi-femme mi-poisson, elle symbolise la beauté, la richesse et la fertilité. Selon la légende, elle peut accorder fortune et prospérité à ceux qui la respectent, mais punir sévèrement ceux qui la trahissent. Son culte reste vivace sur les côtes béninoises.',
                'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
                'date_creation' => Carbon::now()->subDays(4),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDay(),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeLegende->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Les Palais Royaux d\'Abomey',
                'texte' => 'Les Palais Royaux d\'Abomey sont un ensemble de 12 palais construits par les rois successifs du Dahomey entre le 17ème et le 19ème siècle. Inscrits au patrimoine mondial de l\'UNESCO, ces palais témoignent de la puissance du royaume précolonial. Leurs bas-reliefs racontent l\'histoire glorieuse des Amazones du Dahomey et des conquêtes royales.',
                'image' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?w=800',
                'date_creation' => Carbon::now()->subDays(2),
                'statut' => 'en_attente',
                'date_validation' => null,
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typePatrimoine->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => null,
            ],
            [
                'titre' => 'Documentaire : Les Danses Traditionnelles du Bénin',
                'texte' => 'Découvrez la richesse et la diversité des danses traditionnelles béninoises dans ce documentaire captivant. Des rythmes endiablés du Zangbeto aux mouvements gracieux du Tchinkounmè, chaque danse raconte une histoire, célèbre un événement ou honore les ancêtres. Ces danses, transmises de génération en génération, constituent un patrimoine immatériel précieux qui continue de rythmer la vie sociale et culturelle du Bénin. Le Gèlèdé, inscrit au patrimoine de l\'UNESCO, est une danse masquée spectaculaire qui célèbre le pouvoir mystique des femmes âgées. Portés par des danseurs masculins, les masques représentent des figures féminines idéalisées et sont sculptés avec une grande finesse artistique.',
                'image' => 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?w=800',
                'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'date_creation' => Carbon::now()->subDays(7),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(4),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeArticle->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'La Cuisine Béninoise : Un Voyage Culinaire',
                'texte' => 'La gastronomie béninoise est un véritable trésor culturel qui reflète la diversité des peuples et des régions du pays. Du Nord au Sud, de l\'Est à l\'Ouest, chaque région possède ses spécialités culinaires uniques, préparées avec des ingrédients locaux et des techniques ancestrales transmises de mère en fille depuis des siècles.

Le plat national, l\'Amiwo, est une bouillie de maïs rouge accompagnée d\'une sauce tomate épicée et de poulet ou de poisson. Dans le Nord, le Wagassi, fromage de lait de vache fumé, est une spécialité peule très prisée. Le Tchigan, également appelé Aloko, consiste en des bananes plantains frites servies avec une sauce pimentée.

L\'huile de palme rouge, appelée "oro" en langue locale, est l\'élément de base de nombreuses sauces. Elle donne cette couleur orangée caractéristique à de nombreux plats béninois. Le Gboma Dessi, une sauce aux épinards locaux, le Kpété, préparé avec des arachides grillées, ou encore le Yèkè Yèkè, un ragoût de viande épicé, sont autant de délices qui composent le riche patrimoine culinaire du Bénin.

Les marchés regorgent de produits frais : ignames, manioc, gombo, piments, tomates, et une variété impressionnante de poissons frais ou fumés. La préparation des repas est souvent un moment convivial où les femmes se réunissent pour partager recettes et secrets culinaires, perpétuant ainsi les traditions tout en innovant avec créativité.',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800',
                'video' => 'https://www.youtube.com/watch?v=abc123xyz',
                'date_creation' => Carbon::now()->subDays(5),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(3),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeArticle->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Les Cérémonies Vodoun : Spiritualité et Tradition',
                'texte' => 'Le Vodoun (ou Vaudou) est la religion traditionnelle du Bénin, berceau mondial de cette spiritualité ancestrale qui compte des millions de pratiquants à travers le monde, notamment dans les Caraïbes et les Amériques. Contrairement aux représentations hollywoodiennes souvent erronées, le Vodoun est une religion sophistiquée avec un panthéon complexe de divinités, des rituels élaborés et une philosophie profonde sur la relation entre l\'homme, la nature et le monde spirituel.

Chaque 10 janvier, le Bénin célèbre la Fête Nationale du Vodoun, reconnue officiellement depuis 1996. Cette journée est marquée par des cérémonies spectaculaires dans tout le pays, particulièrement à Ouidah, ville sacrée du Vodoun. Les prêtres et prêtresses, vêtus de leurs habits traditionnels blancs et rouges, invoquent les divinités par des chants, des danses et des offrandes.

Le panthéon vodoun comprend Mawu-Lisa (le dieu créateur), Sakpata (divinité de la terre et de la variole), Heviosso (dieu du tonnerre), Dan (le serpent arc-en-ciel), et bien d\'autres. Chaque divinité a ses attributs, ses couleurs sacrées, ses chants et ses danses spécifiques.

Les temples vodoun, appelés couvents, sont des lieux sacrés où se déroulent initiations et cérémonies. Les adeptes y apprennent les secrets des plantes médicinales, les danses rituelles et les incantations sacrées. Cette transmission du savoir garantit la perpétuation de traditions millénaires tout en s\'adaptant au monde moderne.

Le Vodoun joue également un rôle social important : règlement des conflits, guérison des malades par les plantes, protection des communautés. Il incarne une vision holistique du monde où spiritualité, nature et société sont intimement liées.',
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800',
                'video' => 'https://vimeo.com/123456789',
                'date_creation' => Carbon::now()->subDays(12),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(8),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typePatrimoine->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'L\'Artisanat Béninois : Entre Tradition et Innovation',
                'texte' => 'L\'artisanat béninois est reconnu internationalement pour sa qualité exceptionnelle et sa créativité. Les artisans béninois excellent dans de nombreux domaines : sculpture sur bois, travail du bronze, tissage, vannerie, poterie, teinture et batik. Chaque région du Bénin a développé ses propres spécialités artisanales, reflétant son histoire, sa culture et ses ressources naturelles.

À Abomey, les appliqués sur tissu sont une tradition séculaire. Ces tapisseries colorées racontent l\'histoire des rois du Dahomey à travers des symboles et des scènes de bataille. Chaque couleur, chaque motif a une signification précise dans ce langage visuel complexe. Les artisans contemporains perpétuent cet art tout en créant des œuvres modernes qui séduisent collectionneurs et amateurs d\'art du monde entier.

La région de Porto-Novo est célèbre pour ses masques Gèlèdé, sculptures polychromes représentant des visages féminins surmontés de scènes de la vie quotidienne ou d\'animaux totémiques. La fabrication d\'un masque peut prendre plusieurs semaines et requiert une grande maîtrise technique et une profonde connaissance des symboles culturels.

Le bronze du Bénin, dont les techniques remontent au royaume du Dahomey, continue de fasciner. Les artisans utilisent la technique de la cire perdue pour créer des statues, des bijoux et des objets décoratifs d\'une finesse remarquable. Les représentations des rois, des guerriers et des divinités vodoun sont particulièrement prisées.

Le tissage traditionnel produit des pagnes colorés aux motifs symboliques. Le pagne tissé à la main, appelé "kpokpo", est porté lors des cérémonies importantes. Chaque motif a un nom et une signification : "agodjié" (courage), "klala" (l\'union fait la force), "gbè" (la vie).

Les marchés artisanaux, comme celui de Cotonou ou d\'Ouidah, sont de véritables musées à ciel ouvert où l\'on peut observer les artisans au travail et acquérir des pièces uniques. Cette industrie artisanale emploie des milliers de personnes et constitue un pilier de l\'économie culturelle béninoise.',
                'image' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800',
                'date_creation' => Carbon::now()->subDays(15),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(10),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeArticle->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Les Amazones du Dahomey : Guerrières Légendaires',
                'texte' => 'Les Amazones du Dahomey, connues sous le nom de Mino (nos mères en langue fon), constituent l\'un des rares exemples historiques de femmes soldats dans l\'histoire militaire mondiale. Du 17ème au 19ème siècle, ces guerrières d\'élite formaient un corps d\'armée redoutable qui impressionna tous ceux qui les rencontrèrent, y compris les colonisateurs européens.

Recrutées dès l\'adolescence, ces femmes suivaient un entraînement intensif qui les transformait en combattantes exceptionnelles. Elles maîtrisaient le maniement de diverses armes : machettes, fusils, arcs et flèches. Leur courage au combat était légendaire, et elles étaient souvent placées en première ligne lors des batailles.

Les Amazones étaient organisées en plusieurs régiments spécialisés. Les "gulohento" (chasseresses d\'éléphants) étaient armées de longs couteaux pour affronter les pachydermes et les ennemis au corps à corps. Les "gohento" (arbalétriers) utilisaient des arcs et des flèches. Les "nyekplohento" (faucheurs) maniaient des rasoirs géants attachés à de longs bâtons.

Leur statut social était unique. Considérées comme les épouses du roi, elles vivaient dans l\'enceinte du palais royal et ne pouvaient se marier ou avoir des enfants. Ce sacrifice personnel était compensé par un prestige considérable et des privilèges matériels. Elles jouissaient d\'une autorité que peu d\'hommes possédaient.

Lors de la guerre contre les Français en 1890-1894, les Amazones se distinguèrent par leur bravoure. Face aux armes à feu modernes et à l\'artillerie française, elles n\'hésitèrent pas à charger, infligeant de lourdes pertes aux troupes coloniales avant d\'être finalement vaincues par la supériorité technologique européenne.

Aujourd\'hui, la mémoire des Amazones est célébrée au Bénin comme un symbole de courage, de dévouement et de l\'émancipation féminine. Statues, films et œuvres d\'art leur rendent hommage, perpétuant le souvenir de ces guerrières extraordinaires qui défendirent leur royaume avec une bravoure sans égale.',
                'image' => 'https://images.unsplash.com/photo-1494537176433-7a3c4ef2046f?w=800',
                'video' => 'https://www.youtube.com/watch?v=amazones123',
                'date_creation' => Carbon::now()->subDays(20),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDays(15),
                'id_region' => $regionAtlantique->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typeArticle->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
            [
                'titre' => 'Reportage : Le Parc National de la Pendjari',
                'texte' => 'Explorez la faune sauvage du Parc National de la Pendjari, l\'une des dernières réserves importantes d\'Afrique de l\'Ouest. Ce sanctuaire abrite éléphants, lions, léopards, buffles et une biodiversité exceptionnelle dans des paysages à couper le souffle.',
                'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800',
                'video' => 'https://www.youtube.com/watch?v=wildlife456',
                'date_creation' => Carbon::now()->subDays(3),
                'statut' => 'validé',
                'date_validation' => Carbon::now()->subDay(),
                'id_region' => $regionAtacora->id_region,
                'id_langue' => $langueFr->id_langue,
                'id_type_contenu' => $typePatrimoine->id_type_contenu,
                'id_auteur' => $auteur->id_utilisateur,
                'id_moderateur' => $auteur->id_utilisateur,
            ],
        ];

        foreach ($contenus as $contenu) {
            Contenu::create($contenu);
        }
    }
}
