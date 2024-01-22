<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimedToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token_holder_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function token_holder()
    {
        return $this->belongsTo(TokenHolder::class, 'token_holder_id');
    }
}
