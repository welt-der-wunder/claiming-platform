<?php

namespace App\Models;

use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Traits\FormattedTimestamps;
use App\Util\UserRoles;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens, HasFactory, Notifiable, FormattedTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'account_type',
        'birthday',
        'phone',
        'country_code',
        'country',
        'address',
        'city',
        'postal_code',
        'role',
        'image_id',
        'is_verified',
        'public_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'is_account_complete',
    ];

    const PERSONAL_ACCOUNT = 'personal';
    const BUSINESS_ACCOUNT = 'business';

    const ACCOUNT_TYPES = [
        self::PERSONAL_ACCOUNT,
        self::BUSINESS_ACCOUNT
    ];

    public function scopeFilter(Builder $builder, $filter){

    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
    
    public function setPasswordAttribute($value){

        $this->attributes['password'] = Hash::make($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getIsAccountCompleteAttribute()
    {
        $accountType = $this->account_type;

        if($accountType == self::PERSONAL_ACCOUNT && $this->is_verified) {
            return $this->personalDataComplete($this);
        }

        return true;
    }

    public function personalDataComplete($user)
    {
        foreach ($this->fillable as $attribute) {

            if($attribute == 'role' || $attribute == 'image_id' || $attribute == 'is_verified') 
                continue;
            $value = $this->{$attribute};

            if (!is_null($value) && $value !== '') {
                return false;
            }
        }

        return true;
    }

    public function isAdmin(): bool
    {
        return UserRoles::$ROLE_ADMIN == $this->role;
    }

    public static function getAdminEmails() 
    {
        $emails = User::where('role', UserRoles::$ROLE_ADMIN)->pluck('email')->toArray();

        array_push($emails, config('app.victorum_admin_email'));

        return $emails;
    }
}
