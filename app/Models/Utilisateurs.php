<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\com;


class Utilisateurs extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table et clef primaire
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_utilisateur';

    // La table contient les timestamps
    // La table contient les timestamps (migration ajoute created_at/updated_at)
    public $timestamps = true;

    // Attributs mass assignable
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'sexe',
        'date_inscription',
        'date_naissance',
        'statut',
        'photo',
        'id_role',
        'id_langue',
    ];

    // Cacher le mot de passe
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Casts
    protected $casts = [
        'date_inscription' => 'date',
        'date_naissance' => 'date',
    ];

    // Accessor pour garder la compatibilité avec $user->id dans les vues
    public function getIdAttribute()
    {
        return $this->attributes['id_utilisateur'] ?? null;
    }
    

    // Accessor pour $user->actif (boolean) utilisé dans certaines vues
    public function getActifAttribute()
    {
        return isset($this->attributes['statut']) && $this->attributes['statut'] === 'actif';
    }

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

     public function setPasswordAttribute($value)
    {
        $this->attributes['mot_de_passe'] = $value;
    }


      public function getEmailForPasswordReset()
    {
        return $this->email;
    }
    
    // 5. Pour les notifications
    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
        }
    }

     
     public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'id_utilisateur', 'id_utilisateur');
    }


    public function recettes()
{
    return $this->hasMany(Contenu::class, 'id_auteur', 'id_utilisateur')
                ->where('id_type_contenu', 1);
}

public function histoires()
{
    return $this->hasMany(Contenu::class, 'id_auteur', 'id_utilisateur')
                ->whereIn('id_type_contenu', [2, 3]);
}
 public function getFullNameAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }
     public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/profiles/' . $this->photo);
        }
        return asset('assets/img/travel/default.jpeg');
    }
    
}
