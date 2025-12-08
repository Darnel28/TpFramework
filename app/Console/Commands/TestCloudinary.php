<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TestCloudinary extends Command
{
    protected $signature = 'cloudinary:test';
    protected $description = 'Tester la connexion Cloudinary';

    public function handle()
    {
        $this->info('🧪 Test de connexion Cloudinary...');
        $this->newLine();
        
        // Vérifier les variables d'environnement
        $cloudName = config('cloudinary.cloud_url') ? 'Configuré via URL' : env('CLOUDINARY_CLOUD_NAME');
        $this->info('Cloud Name: ' . ($cloudName ?? 'NON DÉFINI'));
        $this->info('API Key: ' . (env('CLOUDINARY_API_KEY') ?? 'NON DÉFINI'));
        $this->newLine();
        
        try {
            // Tester avec une image de test
            $testImagePath = public_path('assets/img/travel/logo.png');
            
            if (!file_exists($testImagePath)) {
                $this->error('❌ Fichier de test non trouvé: ' . $testImagePath);
                $this->info('💡 Essayez avec un autre fichier d\'image existant');
                return 1;
            }
            
            $this->info('📤 Upload d\'une image de test...');
            
            // Upload direct avec Cloudinary
            $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($testImagePath, [
                'folder' => 'culturebenin/test',
                'public_id' => 'test_' . time(),
            ]);
            
            $this->newLine();
            $this->info('✅ Upload réussi!');
            $this->info('🌐 URL: ' . $result->getSecurePath());
            $this->info('🆔 Public ID: ' . $result->getPublicId());
            $this->newLine();
            
            // Supprimer l'image de test
            $this->info('🗑️  Suppression de l\'image de test...');
            \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::destroy($result->getPublicId());
            $this->info('✅ Image de test supprimée');
            
            $this->newLine();
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('🎉 Cloudinary fonctionne parfaitement!');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Erreur: ' . $e->getMessage());
            $this->newLine();
            $this->warn('💡 Vérifiez vos identifiants Cloudinary dans le fichier .env');
            $this->warn('💡 Assurez-vous que CLOUDINARY_URL est correctement configuré');
            return 1;
        }
    }
}
