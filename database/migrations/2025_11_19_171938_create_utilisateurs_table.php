<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
              $table->id('id_utilisateur');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('sexe', 10)->nullable();
            $table->date('date_inscription')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('statut')->default('inactif');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('id_role');
    $table->unsignedBigInteger('id_langue');

    $table->foreign('id_role')->references('id_role')->on('role');
    $table->foreign('id_langue')->references('id_langue')->on('langue');

    $table->timestamps();
            

           


           
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
