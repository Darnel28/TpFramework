<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FedapayTransaction extends Model
{
    protected $table = 'fedapay_transactions';
    protected $fillable = [
        'fedapay_id',
        'content_id',
        'user_id',
        'status',
        'amount',
        'currency',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'json',
    ];
}
