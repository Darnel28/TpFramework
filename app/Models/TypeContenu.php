<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeContenu extends Model
{
    protected $table = 'typecontenu';
    protected $primaryKey = 'id_type_contenu';
    protected $fillable = [
        'nom_contenu',
    ];

    public $timestamps = true;
}
