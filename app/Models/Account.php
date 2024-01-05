<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $primaryKey = 'identifier';
    protected const COUNTRY_CODE = 'LV';
    protected const PREFIX = 'HOHO42';
    public $incrementing = false;

    protected $fillable = [
        'currency',
        'type',
        'balance',
        'user_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Account $account) {
            $account->identifier = $account->generateIdentifier();
        });
    }

    private function generateIdentifier(): string
    {
        return self::COUNTRY_CODE . self::PREFIX . self::generateAccountNumber();
    }

    private function generateAccountNumber(): string
    {
        return strval(rand(1000000000, 9999999999));
    }
}
