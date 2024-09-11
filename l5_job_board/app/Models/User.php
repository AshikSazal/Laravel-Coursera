<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Verify;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    protected $guard = "user";

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'verification'
    ];

    public function userVerification()
    {
        return $this->hasOne(Verify::class);
    }
}
