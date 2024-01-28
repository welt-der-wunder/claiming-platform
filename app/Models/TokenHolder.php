<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TokenHolder extends Model
{
    use HasFactory;


    protected $fillable = [
        'blockno',
        'unix_timestamp',
        'date_time',
        'from',
        'holder_address',
        'block_hash',
        'token_type',
        'is_claimed'
    ];


    public function scopeFilter(Builder $builder, $filter){

        if(isset($filter['is_claimed'])) {
            $builder->where('is_claimed', $filter['is_claimed']);
        }

        if(isset($filter['holder_search'])) {
            $builder->where(function($q) use($filter) {
                $q->where('holder_address','LIKE','%'. $filter['holder_search'] .'%');
                $q->orWhere('from','LIKE','%'. $filter['holder_search'] .'%');
            });
   
        }

        return $builder;
    }
}
