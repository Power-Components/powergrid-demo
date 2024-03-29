<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
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
        if (Cache::supportsTags()) {
            Cache::tags(['powergrid-users-validationTable'])->flush();
        }
    }
}
