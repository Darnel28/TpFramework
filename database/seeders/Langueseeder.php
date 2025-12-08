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
       \App\Models\Langue::create(['nom_langue'=>'tori', 'code_langue'=>'tori', 'description'=>'langue du benin']);
    }
}
