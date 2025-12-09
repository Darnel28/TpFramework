<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeContenu;

class TypeContenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typesContenu = [
            ['nom_contenu' => 'Article'],
            ['nom_contenu' => 'Légende'],
            ['nom_contenu' => 'Patrimoine'],
            ['nom_contenu' => 'Tradition'],
            ['nom_contenu' => 'Histoire'],
            ['nom_contenu' => 'Culture'],
            ['nom_contenu' => 'Art'],
            ['nom_contenu' => 'Musique'],
        ];

        foreach ($typesContenu as $type) {
            TypeContenu::create($type);
        }
    }
}
