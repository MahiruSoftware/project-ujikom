<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Scopes\AddLastLoginAtScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'users';

    protected $hidden = ['id', 'password'];

    protected $dates = ['last_login_at', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new AddLastLoginAtScope());
    }

    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }

    public function getLastLoginAtAttribute($value)
    {
        return $value ?: '';
    }

    protected $casts = [
        'created_at'=> 'datetime:Y-m-d H:i:s',
        'updated_at'=> 'datetime:Y-m-d H:i:s',
        'last_login_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'username',
        'password'
    ];
}
