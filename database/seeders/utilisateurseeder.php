<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateurs;
use Carbon\Carbon;

class utilisateurseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // S'assurer que les FK existent
        DB::table('role')->updateOrInsert(
            ['id_role' => 2],
            ['nom_role' => 'contributeur']
        );

        DB::table('langue')->updateOrInsert(
            ['id_langue' => 1],
            ['nom_langue' => 'Français', 'code_langue' => 'fr']
        );

        // Créer ou mettre à jour l'utilisateur de test
        Utilisateurs::updateOrCreate(
            ['email' => 'morgane.deguenon@example.com'],
            [
                'nom' => 'DEGUENON',
                'prenom' => 'Morgane',
                'mot_de_passe' => bcrypt('password123'),
                'sexe' => 'F',
                'date_inscription' => Carbon::parse('2024-01-15'),
                'date_naissance' => Carbon::parse('1995-06-20'),
                'statut' => 'actif',
                'id_role' => 2,
                'id_langue' => 1,
            ]
        );
    }
}
