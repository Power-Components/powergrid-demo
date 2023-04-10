<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted(): void
    {
        static::created(fn (User $user) => self::clearCache());
        static::updated(fn (User $user) => self::clearCache());
        static::deleted(fn (User $user) => self::clearCache());
    }

    private static function clearCache(): void
    {
        Cache::tags(['powergrid-users-validationTable'])->flush();
    }
}
