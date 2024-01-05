<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'from_account',
        'to_account',
        'sent_amount',
        'received_amount',
        'sent_currency',
        'received_currency',
        'note'
    ];
}
