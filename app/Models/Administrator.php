<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use App\Scopes\AddLastLoginAtScope;

// class Administrator extends Model
// {
//     use HasFactory, HasApiTokens;

//     public $timestamps = false;
//     // protected $table = 'administrator'; // Nama tabel secara eksplisit

//     protected $guarded = ['id'];
//     protected $hidden = [
//         'password'
//     ];

//     protected $casts = [
//         'password' => 'hashed',
//     ];

// }
// app/Models/Administrator.php


class Administrator extends Authenticatable
{
    use HasApiTokens;

    protected $guard = 'administrator';

    protected $hidden = ['id', 'password'];

    protected $dates = ['last_login_at', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new AddLastLoginAtScope());
    }

    public function isAdmin()
    {
        return true;
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
        'last_login_at' => 'datetime:Y-m-d H:i:s',
    ];
}

