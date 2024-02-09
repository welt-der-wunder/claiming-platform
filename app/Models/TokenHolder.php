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
        'is_claimed',
        'status'
    ];

    const HOLDER_STATUS_CLAIMED = 'Claimed';
    const HOLDER_STATUS_BLOCKED = 'Blocked';
    const HOLDER_STATUS_UNCLAIMED = 'Unclaimed';

    const HOLDER_STATUSES = [
        self::HOLDER_STATUS_CLAIMED,
        self::HOLDER_STATUS_BLOCKED,
        self::HOLDER_STATUS_UNCLAIMED
    ];


    public function scopeFilter(Builder $builder, $filter){

        if(isset($filter['status'])) {
            $builder->where('status', $filter['status']);
        }

        if(isset($filter['holder_search'])) {
            $builder->where(function($q) use($filter) {
                $q->where('holder_address','LIKE','%'. $filter['holder_search'] .'%');
                $q->orWhere('from','LIKE','%'. $filter['holder_search'] .'%');
            });
   
        }

        $builder->orderBy('id', 'desc');

        return $builder;
    }
}
