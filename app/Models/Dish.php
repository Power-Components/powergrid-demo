<?php

namespace App\Models;

use App\Enums\CookingMethod;
use App\Enums\NutriScore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * @property int $id
 * @property Kitchen $kitchen_id
 * @property Category $category_id
 * @property string $name
 * @property float $price
 * @property int $calories
 * @property bool $in_stock
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $produced_at
 * @property-read Kitchen $kitchen
 * @property-read Category $category
 */
class Dish extends Model
{
    use HasFactory;
    use SoftDeletes;

   protected $with = ['category', 'kitchen', 'chef'];

    protected $fillable = [
        'kitchen_id',
        'category_id',
        'name',
        'price',
        'calories',
        'in_stock',
    ];

    protected $casts = [
        'nutri_score'    => NutriScore::class,
        'cooking_method' => CookingMethod::class,
    ];

    protected static function booted(): void
    {
        static::created(fn ($dish) => self::clearCache());
        static::updated(fn ($dish) => self::clearCache());
        static::deleted(fn ($dish) => self::clearCache());
    }

    private static function clearCache(): void
    {
        if (Cache::supportsTags()) {
            Cache::tags(['powergrid-dishes-simpleTable'])->flush();
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function kitchen(): BelongsTo
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function chef(): BelongsTo
    {
        return $this->belongsTo(Chef::class);
    }

    public static function servedAt()
    {
        return self::select('serving_at')->distinct('serving_at')->get();
    }
}
