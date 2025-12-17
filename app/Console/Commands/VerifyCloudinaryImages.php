<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contenu;
use Illuminate\Support\Facades\Http;

class VerifyCloudinaryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:verify-cloudinary {--fix : Corriger les images cassées}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier et nettoyer les URLs Cloudinary des contenus';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Vérification des images Cloudinary...');

        $contenus = Contenu::whereNotNull('image')->get();

        if ($contenus->isEmpty()) {
            $this->info('✅ Aucun contenu avec image trouvé.');
            return 0;
        }

        $this->info("📊 {$contenus->count()} contenus à vérifier");

        $brokenCount = 0;
        $validCount = 0;

        foreach ($contenus as $contenu) {
            if ($this->isValidCloudinaryUrl($contenu->image)) {
                $validCount++;
                $this->line("✅ {$contenu->titre} - URL valide");
            } else {
                $brokenCount++;
                $this->line("❌ {$contenu->titre} - URL invalide: {$contenu->image}");

                if ($this->option('fix')) {
                    $contenu->image = null;
                    $contenu->save();
                    $this->line("   → Image supprimée");
                }
            }
        }

        $this->newLine();
        $this->info("📈 Résumé:");
        $this->info("   ✅ URLs valides: {$validCount}");
        $this->info("   ❌ URLs cassées: {$brokenCount}");

        if ($this->option('fix') && $brokenCount > 0) {
            $this->info("✨ {$brokenCount} images cassées ont été supprimées");
        }

        return 0;
    }

    /**
     * Vérifie si une URL Cloudinary est valide
     */
    private function isValidCloudinaryUrl($url)
    {
        // Vérifier que c'est une URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Vérifier que c'est une URL Cloudinary
        if (!str_contains($url, 'cloudinary.com')) {
            return false;
        }

        // Vérifier que l'image existe (optionnel - peut être lent)
        try {
            $response = Http::timeout(5)->head($url);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
