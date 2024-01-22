<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenHolder extends Model
{
    use HasFactory;


    protected $fillable = [
        'blockno',
        'unix_timestamp',
        'date_time',
        'from',
        'hoolder_address',
        'block_hash',
        'token_type',
        'is_claimed'
    ];
}
