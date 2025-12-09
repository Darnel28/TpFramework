<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Langueseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Langue::create(['nom_langue'=>'Français', 'code_langue'=>'fr', 'description'=>'Langue officielle du Bénin']);
        \App\Models\Langue::create(['nom_langue'=>'Tori', 'code_langue'=>'tori', 'description'=>'Langue du Bénin']);
        \App\Models\Langue::create(['nom_langue'=>'Fon', 'code_langue'=>'fon', 'description'=>'Langue du Bénin']);
        \App\Models\Langue::create(['nom_langue'=>'Yoruba', 'code_langue'=>'yo', 'description'=>'Langue du Bénin']);
    }
}
