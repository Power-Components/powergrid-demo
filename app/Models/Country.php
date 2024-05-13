<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    public $timestamps = false;

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities(): HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
