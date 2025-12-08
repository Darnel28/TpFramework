<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contenu;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'images:migrate-cloudinary';
    protected $description = 'Migrer toutes les images locales vers Cloudinary';

    public function handle()
    {
        $this->info('🚀 Début de la migration des images vers Cloudinary...');
        $this->newLine();
        
        // Récupérer tous les contenus avec images
        $contenus = Contenu::whereNotNull('image')
            ->where('image', 'not like', 'https://res.cloudinary.com%')
            ->get();
        
        $total = $contenus->count();
        
        if ($total === 0) {
            $this->info('✅ Aucune image à migrer. Toutes les images sont déjà sur Cloudinary!');
            return 0;
        }
        
        $this->info("📊 Total de contenus à traiter: {$total}");
        $this->newLine();
        
        $progressBar = $this->output->createProgressBar($total);
        $progressBar->start();
        
        $migrated = 0;
        $errors = 0;
        $skipped = 0;

        foreach ($contenus as $contenu) {
            try {
                // Construire le chemin local de l'image
                $imagePath = $contenu->image;
                
                // Vérifier différents chemins possibles
                $possiblePaths = [
                    public_path($imagePath),
                    public_path('/' . $imagePath),
                    storage_path('app/public/' . str_replace('storage/', '', $imagePath)),
                ];
                
                $localPath = null;
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        $localPath = $path;
                        break;
                    }
                }
                
                if (!$localPath) {
                    $this->newLine();
                    $this->warn("⚠️  Fichier introuvable: {$imagePath}");
                    $skipped++;
                    $progressBar->advance();
                    continue;
                }

                // Upload vers Cloudinary
                $uploadedFile = Cloudinary::upload($localPath, [
                    'folder' => 'culturebenin/contenus',
                    'public_id' => 'contenu_' . $contenu->id_contenu . '_' . time(),
                    'resource_type' => 'auto',
                    'overwrite' => true,
                ]);

                // Récupérer l'URL sécurisée de Cloudinary
                $cloudinaryUrl = $uploadedFile->getSecurePath();
                $publicId = $uploadedFile->getPublicId();

                // Mettre à jour la base de données
                $contenu->update([
                    'image' => $cloudinaryUrl,
                ]);

                $migrated++;
                
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("❌ Erreur pour le contenu ID {$contenu->id_contenu}: " . $e->getMessage());
                $errors++;
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        
        $this->newLine(2);
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('✅ Migration terminée!');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
        $this->info("📈 Images migrées avec succès: {$migrated}/{$total}");
        
        if ($skipped > 0) {
            $this->warn("⏭️  Images ignorées (introuvables): {$skipped}");
        }
        
        if ($errors > 0) {
            $this->error("⚠️  Erreurs rencontrées: {$errors}");
        }
        
        $this->newLine();
        $this->info('🎉 Vos images sont maintenant hébergées sur Cloudinary!');
        $this->info('🌐 URL Cloudinary: https://console.cloudinary.com/');

        return 0;
    }
}
