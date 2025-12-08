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
        Schema::create('contenu', function (Blueprint $table) {
             $table->id('id_contenu');
            $table->string('titre');
            $table->text('texte')->nullable();
            $table->date('date_creation')->nullable();
            $table->string('statut')->default('en_attente');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->date('date_validation')->nullable();
            $table->unsignedBigInteger('id_region');
            $table->unsignedBigInteger('id_langue');
            $table->unsignedBigInteger('id_moderateur')->nullable();
            $table->unsignedBigInteger('id_type_contenu');
            $table->unsignedBigInteger('id_auteur');

            $table->foreign('id_region')->references('id_region')->on('region');
            $table->foreign('id_langue')->references('id_langue')->on('langue');
            $table->foreign('id_moderateur')->references('id_utilisateur')->on('utilisateurs');
            $table->foreign('id_type_contenu')->references('id_type_contenu')->on('typecontenu');
            $table->foreign('id_auteur')->references('id_utilisateur')->on('utilisateurs');
            
            
            
            

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenu');
    }
};
