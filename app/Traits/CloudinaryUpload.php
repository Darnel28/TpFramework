<?php

namespace App\Traits;

use Cloudinary\Cloudinary;

trait CloudinaryUpload
{
    /**
     * Upload un fichier vers Cloudinary
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder Dossier de destination (ex: 'culturebenin/contenus')
     * @return string|null URL sécurisée du fichier uploadé ou null en cas d'erreur
     */
    public function storeOnCloudinary($file, $folder = 'culturebenin/default')
    {
        try {
            if (!$file || !$file->isValid()) {
                \Log::error('Cloudinary upload - Invalid file');
                return null;
            }

            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);

            $uploadOptions = [
                'folder' => $folder,
                'resource_type' => 'auto',
                'eager' => [
                    ['quality' => 'auto', 'fetch_format' => 'auto'],
                ],
                'eager_async' => false,
            ];

            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), $uploadOptions);

            if (!isset($result['secure_url'])) {
                \Log::error('Cloudinary upload - Missing secure_url in response', ['result' => $result]);
                return null;
            }

            $url = $result['secure_url'];
            
            // Vérifier que l'URL est valide
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                \Log::error('Cloudinary upload - Invalid URL returned', ['url' => $url]);
                return null;
            }

            \Log::info('Cloudinary upload successful', [
                'file' => $file->getClientOriginalName(),
                'folder' => $folder,
                'url' => $url,
            ]);

            return $url;
        } catch (\Throwable $e) {
            \Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName() ?? 'unknown',
                'folder' => $folder,
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Upload un fichier avec un nom personnalisé
     */
    public function storeOnCloudinaryWithName($file, $name, $folder = 'culturebenin/default')
    {
        try {
            if (!$file || !$file->isValid()) {
                return null;
            }

            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);

            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'public_id' => $folder . '/' . $name,
                'resource_type' => 'auto',
                'overwrite' => true,
            ]);

            return $result['secure_url'] ?? null;
        } catch (\Throwable $e) {
            \Log::error('Cloudinary upload with name failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName() ?? 'unknown',
                'name' => $name,
                'folder' => $folder,
            ]);
            return null;
        }
    }
}
