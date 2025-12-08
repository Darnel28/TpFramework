<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id_commentaire';

    public $timestamps = true;

    protected $fillable = [
        'texte',
        'note',
        'date',
        'id_contenu',
        'id_utilisateur',
    ];

    protected $casts = [
        'date' => 'datetime',
        'note' => 'integer'
    ];

    /**
     * Relation avec le contenu
     */
    public function contenu(): BelongsTo
    {
        return $this->belongsTo(Contenu::class, 'id_contenu', 'id_contenu');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateurs::class, 'id_utilisateur', 'id_utilisateur');
    }
     public function getUserPhotoAttribute()
    {
        if ($this->utilisateur && $this->utilisateur->photo) {
            return asset('storage/' . $this->utilisateur->photo);
        }
        
        // Photo par défaut basée sur le nom
        $names = ['person-m-9', 'person-f-5', 'person-f-12', 'person-m-12', 'person-m-13'];
        $randomName = $names[array_rand($names)];
        return asset('assets/img/person/' . $randomName . '.webp');
    }
    
    /**
     * Get user display name
     */
    public function getUserDisplayNameAttribute()
    {
        if ($this->utilisateur) {
            return $this->utilisateur->nom . ' ' . $this->utilisateur->prenom;
        }
        
        return $this->nom;
    }
    
    /**
     * Format date
     */
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->date_creation)
            ->locale('fr')
            ->diffForHumans();
    }
}