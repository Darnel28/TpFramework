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
        Schema::create('parler', function (Blueprint $table) {
             $table->unsignedBigInteger('id_region');
            $table->unsignedBigInteger('id_langue');
            $table->foreign('id_region')->references('id_region')->on('region')->onDelete('cascade');
            $table->foreign('id_langue')->references('id_langue')->on('langue')->onDelete('cascade');

            $table->primary(['id_region', 'id_langue']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parler');
    }
};
