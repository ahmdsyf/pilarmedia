<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const STATUS = ['1' =>'Active', '0' => 'Unactive'];

    protected $guarded = ['id'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth()->user()->id ?? 2;
            $query->updated_by = auth()->user()->id ?? 2;
        });

        static::updating(function ($query) {
            $query->updated_by = auth()->user()->id ?? 2;
        });
    }

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
}
