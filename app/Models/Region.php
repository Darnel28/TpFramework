<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    // Nom de la table
    protected $table = 'region';

    // Clé primaire personnalisée
    protected $primaryKey = 'id_region';

    // Si vous n'utilisez pas les timestamps created_at/updated_at
    public $timestamps = false;

    // Champs mass-assignable (ajustez selon votre schéma)
    protected $fillable = [
        'nom_region',
        'description',
        'population',
        'superficie',
        'localisation',
    ];

    /**
     * Fournir un alias `id` pour la clé primaire `id_region` afin
     * que les vues utilisant `$region->id` fonctionnent sans changement.
     */
    protected $appends = [];

    public function getIdAttribute()
    {
        return $this->attributes[$this->primaryKey] ?? null;
    }

     public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }
    
    /**
     * Relation avec l'auteur (utilisateur)
     */
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_auteur', 'id_utilisateur');
    }
    
    /**
     * Relation avec la langue
     */
    public function langue(): BelongsTo
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }
    
    /**
     * Relation avec les commentaires
     */
    public function commentaires()
    {
        // Adaptez le nom de la table et clés selon votre base
        return $this->hasMany(Commentaire::class, 'id_contenu', 'id_contenu');
    }
    
    /**
     * Relation avec le type de contenu (si vous avez cette table)
     */
    public function typeContenu(): BelongsTo
    {
        return $this->belongsTo(TypeContenu::class, 'id_type_contenu', 'id_type_contenu');
    }
    public function contenus()
{
    return $this->hasMany(Contenu::class, 'id_region', 'id_region')
        ->where('statut', 'publié');
}

}
      