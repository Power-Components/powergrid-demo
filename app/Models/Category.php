<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends Model
{
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'category_id');
    }

    public function chefs(): BelongsToMany
    {
        return $this->belongsToMany(Chef::class);
    }
}
