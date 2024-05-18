<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Scopes\AddLastLoginAtScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['id', 'password'];
    protected $dates = ['last_login_at', 'created_at', 'updated_at'];
    protected $casts = [
        'password' => 'hashed',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AddLastLoginAtScope());
    }

    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }
}
