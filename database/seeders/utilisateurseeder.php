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
        // Créer les rôles de base
        DB::table('role')->insert([
            ['id_role' => 1, 'nom_role' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 2, 'nom_role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 3, 'nom_role' => 'moderateur', 'created_at' => now(), 'updated_at' => now()],
            ['id_role' => 4, 'nom_role' => 'contributeur', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Créer l'utilisateur admin de test
        Utilisateurs::create([
            'nom' => 'DEGUENON',
            'prenom' => 'Morgane',
            'email' => 'morgane.deguenon@example.com',
            'mot_de_passe' => bcrypt('password123'),
            'sexe' => 'F',
            'date_inscription' => Carbon::parse('2024-01-15'),
            'date_naissance' => Carbon::parse('1995-06-20'),
            'statut' => 'actif',
            'id_role' => 2,
            'id_langue' => 1,
        ]);
    }
}
