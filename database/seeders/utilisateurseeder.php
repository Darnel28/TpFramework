<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class utilisateurseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\utilisateurs::create(['nom'=>'DEGUENON', 'prenom'=>'Morgane', 'email'=>'morgane.deguenon@example.com', 'mot_de_passe'=>bcrypt('password123'), 'sexe'=>'F', 'date_inscription'=>'2024-01-15', 'date_naissance'=>'1995-06-20', 'statut'=>'actif', 'id_role'=>2, 'id_langue'=>1]);
    }
}
