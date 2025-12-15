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
            $table->unsignedBigInteger('fedapay_id')->index();
            $table->unsignedBigInteger('content_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('status', 50)->nullable();
            $table->integer('amount')->default(0);
            $table->string('currency', 10)->default('XOF');
            $table->json('metadata')->nullable();
            $table->timestamps();
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
