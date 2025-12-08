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
        Schema::table('contenu', function (Blueprint $table) {
            if (!Schema::hasColumn('contenu', 'image')) {
                $table->string('image')->nullable()->after('id_auteur');
            }
            if (!Schema::hasColumn('contenu', 'video')) {
                $table->string('video')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenu', function (Blueprint $table) {
            if (Schema::hasColumn('contenu', 'video')) {
                $table->dropColumn('video');
            }
            if (Schema::hasColumn('contenu', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
