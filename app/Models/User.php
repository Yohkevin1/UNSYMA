<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $table = 'users';
    protected $guarded = ['id_user', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at']; // Aktifkan soft deletes
    public $timestamps = true; // Aktifkan timestamps

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function getAuthIdentifier()
    {
        return $this->id_user;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
