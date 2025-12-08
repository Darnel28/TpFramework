<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class Regionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'nom_region' => 'Atacora',
                'description' => 'Région située au nord-ouest du Bénin, connue pour ses montagnes et sa culture Somba',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_region' => 'Atlantique',
                'description' => 'Région côtière du sud, incluant la ville économique de Cotonou',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
