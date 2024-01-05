<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    protected $table = 'crypto';
    protected $primaryKey = 'crypto_symbol';
    public $incrementing = false;
    protected $fillable = [
        'crypto_symbol',
        'USD',
        'EUR',
        'RUB',
        'GBP',
    ];
}
