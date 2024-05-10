<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Restaurant $restaurant_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Chef extends Model
{
    protected $table = 'chefs';

    protected $fillable = [
        'name',
        'restaurant_id',
    ];

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'chef_id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
