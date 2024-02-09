<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'user_id',
        'note',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function  createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function createLog( $users , $title){
        $aryInsertData = [];

        foreach($users as $user) {
            $aryInsertData[] = [
                'user_id' => $user->id,
                'title'   => $title,
                'created_by' => auth()->id() ?? $user->id, 
                'created_at' => now()
            ];
        }

        self::insert($aryInsertData);

    }
}
