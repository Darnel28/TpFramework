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
                'folder' => $folder,
                'resource_type' => 'auto',
            ]);

            return $result['secure_url'] ?? null;
        } catch (\Throwable $e) {
            \Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName() ?? 'unknown',
                'folder' => $folder,
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
