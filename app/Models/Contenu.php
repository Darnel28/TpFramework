<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contenu extends Model
{
    protected $table = 'contenu';
    protected $primaryKey = 'id_contenu';
    public $timestamps = false;
    
    protected $fillable = [
        'titre',
        'texte',
        'date_creation',
        'statut',
        'parent_id',
        'date_validation',
        'id_region',
        'id_langue',
        'id_moderateur',
        'id_type_contenu',
        'id_auteur',
        'image',
        'video'
    ];
    
    /**
     * Mutateur : valider et nettoyer l'URL de l'image avant de la sauvegarder
     */
    public function setImageAttribute($value)
    {
        // Si valeur vide, garder null
        if (empty($value)) {
            $this->attributes['image'] = null;
            return;
        }

        // Vérifier que c'est une URL valide
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            \Log::warning('Invalid image URL attempted to save', [
                'url' => $value,
                'titre' => $this->titre ?? 'Unknown'
            ]);
            $this->attributes['image'] = null;
            return;
        }

        // Vérifier que c'est une URL Cloudinary
        if (!str_contains($value, 'cloudinary.com') && !str_contains($value, 'unsplash.com') && !str_contains($value, 'res.')) {
            \Log::warning('Non-Cloudinary image URL', [
                'url' => $value,
                'titre' => $this->titre ?? 'Unknown'
            ]);
            // Accepter quand même car on peut utiliser d'autres sources
        }

        $this->attributes['image'] = $value;
    }
    
    // AJOUTEZ CETTE PROPRIÉTÉ POUR LES ACCESSORS
    protected $appends = [
        'has_video',
        'is_embed_video',
        'video_url',
        'video_type',
        'video_poster',
        'formatted_date',
        'formatted_rating',
        'image_url'
    ];
    
    public function getRatingAttribute()
    {
        $commentCount = $this->commentaires()->count();
        
        if ($commentCount >= 50) return 5.0;
        if ($commentCount >= 30) return 4.8;
        if ($commentCount >= 20) return 4.5;
        if ($commentCount >= 10) return 4.2;
        if ($commentCount >= 5) return 4.0;
        if ($commentCount >= 2) return 3.8;
        if ($commentCount >= 1) return 3.5;
        
        return 3.0;
    }
    
    /**
     * Vérifie si le contenu a une vidéo
     */
    public function getHasVideoAttribute()
    {
        return !empty($this->video);
    }
    
    /**
     * Vérifie si c'est une vidéo embed (YouTube, Vimeo)
     */
    public function getIsEmbedVideoAttribute()
    {
        if (!$this->has_video) {
            return false;
        }
        
        return preg_match('/(youtube|youtu\.be|vimeo)/i', $this->video);
    }
    
    /**
     * URL complète de la vidéo
     */
    public function getVideoUrlAttribute()
    {
        if (!$this->has_video) {
            return null;
        }

        // Si c'est une vidéo embed (YouTube, Vimeo)
        if ($this->is_embed_video) {
            // Pour YouTube
            if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $this->video, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
            // Pour youtu.be
            if (preg_match('/youtu\.be\/([^?]+)/', $this->video, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
            // Pour Vimeo
            if (preg_match('/vimeo\.com\/(\d+)/', $this->video, $matches)) {
                return 'https://player.vimeo.com/video/' . $matches[1];
            }
            return $this->video;
        }

        // Pour les vidéos uploadées
        // Nettoyer le chemin si nécessaire
        $videoPath = $this->video;
        
        // Si le chemin commence par 'storage/', retirez-le
        if (str_starts_with($videoPath, 'storage/')) {
            $videoPath = str_replace('storage/', '', $videoPath);
        }
        
        // Retourner l'URL complète
        return asset('storage/' . $videoPath);
    }
    
    /**
     * Type MIME de la vidéo
     */
    public function getVideoTypeAttribute()
    {
        if (!$this->has_video || $this->is_embed_video) {
            return null;
        }

        $extension = pathinfo($this->video, PATHINFO_EXTENSION);
        
        switch(strtolower($extension)) {
            case 'mp4': return 'video/mp4';
            case 'webm': return 'video/webm';
            case 'ogg': 
            case 'ogv': return 'video/ogg';
            case 'mov': return 'video/quicktime';
            case 'avi': return 'video/x-msvideo';
            default: return 'video/mp4';
        }
    }
    
    /**
     * Poster pour la vidéo (utilise l'image de couverture)
     */
    public function getVideoPosterAttribute()
    {
        return $this->image_url ?? asset('assets/img/travel/default-video-poster.jpg');
    }
    
    /**
     * URL de l'image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/img/travel/default.jpg');
        }
        
        // Si l'image commence par 'storage/', utilisez asset()
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        // Si c'est déjà une URL complète
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // Par défaut, assumez que c'est dans le storage
        return asset('storage/' . $this->image);
    }
    
    /**
     * Date formatée
     */
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->date_creation)
            ->locale('fr')
            ->isoFormat('LL');
    }
    
    /**
     * Rating formaté
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }
    
    // Les relations
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }
    
    public function auteur()
    {
        return $this->belongsTo(Utilisateurs::class, 'id_auteur', 'id_utilisateur');
    }
    
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }
    
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_contenu', 'id_contenu');
    }
    
    public function moderateur()
    {
        return $this->belongsTo(Utilisateurs::class, 'id_moderateur', 'id_utilisateur');
    }

    public function typecontenu()
    {
        return $this->belongsTo(\App\Models\TypeContenu::class, 'id_type_contenu', 'id_type_contenu');
    }
}