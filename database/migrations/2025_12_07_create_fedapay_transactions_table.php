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
        Schema::create('fedapay_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fedapay_id')->unique(); // ID de la transaction FedaPay
            $table->unsignedBigInteger('content_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('pending'); // pending, approved, declined, canceled
            $table->integer('amount')->default(0);
            $table->string('currency')->default('XOF');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('content_id')->references('id_contenu')->on('contenu')->onDelete('set null');
            $table->foreign('user_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fedapay_transactions');
    }
};
