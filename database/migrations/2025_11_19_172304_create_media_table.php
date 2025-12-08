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
        Schema::create('media', function (Blueprint $table) {
            $table->id('id_media');
            $table->string('chemin');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_contenu');
            $table->unsignedBigInteger('id_type_media');

            $table->foreign('id_contenu')->references('id_contenu')->on('contenu')->onDelete('cascade');
            $table->foreign('id_type_media')->references('id_type_media')->on('typemedia');
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
