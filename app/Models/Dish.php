<?php

namespace App\Models;

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

    protected $with = ['category', 'kitchen'];

    protected $fillable = [
        'kitchen_id',
        'category_id',
        'name',
        'price',
        'calories',
        'in_stock',
    ];

    public static function created($callback): void
    {
        self::clearCache();
    }

    protected static function booted(): void
    {
        static::created(fn (User $user) => self::clearCache());
        static::updated(fn (User $user) => self::clearCache());
        static::deleted(fn (User $user) => self::clearCache());
    }

    private static function clearCache(): void
    {
        Cache::tags(['powergrid-dishes-simpleTable'])->flush();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function kitchen(): BelongsTo
    {
        return $this->belongsTo(Kitchen::class);
    }

    public static function servedAt()
    {
        return self::select('serving_at')->distinct('serving_at')->get();
    }
}
