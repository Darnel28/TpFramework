<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenu;
use Illuminate\Support\Facades\Auth;
use App\Traits\CloudinaryUpload;

class ContenuController extends Controller
{
    use CloudinaryUpload;

    /**
     * Store a new content submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'id_region' => 'required|exists:region,id_region',
            'id_langue' => 'required|exists:langue,id_langue',
            'id_type_contenu' => 'required|integer',
            'image' => 'nullable|image|max:5120', // 5MB
            'video' => 'nullable|url',
            'parent_id' => 'nullable|exists:contenu,id_contenu',
            'agree_terms' => 'required'
        ]);
        
        $contenu = new Contenu();
        $contenu->titre = $request->titre;
        $contenu->texte = $request->texte;
        $contenu->id_region = $request->id_region;
        $contenu->id_langue = $request->id_langue;
        $contenu->id_type_contenu = $request->id_type_contenu;
        $contenu->id_auteur = Auth::id();
        $contenu->date_creation = now();
        $contenu->statut = 'en attente';
        $contenu->parent_id = $request->parent_id ?? 0;
        
        // Handle image upload avec Cloudinary
        if ($request->hasFile('image')) {
            try {
                $imageUrl = $this->storeOnCloudinary($request->file('image'), 'culturebenin/contenus');
                
                if (!$imageUrl) {
                    return redirect()->route('contribute')
                        ->with('error', 'Erreur lors du téléchargement de l\'image. Veuillez réessayer.')
                        ->withInput();
                }
                
                // Valider l'URL avant de la sauvegarder
                if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    \Log::error('Invalid image URL returned from Cloudinary', ['url' => $imageUrl]);
                    return redirect()->route('contribute')
                        ->with('error', 'L\'image uploadée n\'a pas pu être vérifiée. Veuillez réessayer.')
                        ->withInput();
                }
                
                $contenu->image = $imageUrl;
                \Log::info('Image successfully uploaded', ['url' => $imageUrl, 'titre' => $contenu->titre]);
            } catch (\Throwable $e) {
                \Log::error('Image upload exception', ['error' => $e->getMessage()]);
                return redirect()->route('contribute')
                    ->with('error', 'Une erreur est survenue lors du téléchargement de l\'image.')
                    ->withInput();
            }
        }
        
        // Handle video URL
        if ($request->filled('video')) {
            $contenu->video = $request->video;
        }
        
        $contenu->save();

        // Si la contribution est une traduction (parent_id fourni), marquer le parent
        if ($request->filled('parent_id')) {
            try {
                $parent = Contenu::find($request->parent_id);
                if ($parent) {
                    // Conformément à la demande, on met parent_id = 1 sur le contenu parent
                    $parent->parent_id = 1;
                    $parent->save();
                }
            } catch (\Throwable $e) {
                // Ne pas bloquer l'utilisateur si la mise à jour du parent échoue, loggons l'erreur
                \Log::error('Failed to mark parent content after translation submit: ' . $e->getMessage(), ['parent_id' => $request->parent_id]);
            }
        }

        return redirect()->route('contribute')
            ->with('success', 'Votre contribution a été soumise avec succès ! Elle sera examinée par nos modérateurs.');
    }
}