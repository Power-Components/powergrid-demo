<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
 *
 * @property-read Kitchen $kitchen
 * @property-read Category $category
 */
class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'kitchen_id',
        'category_id',
        'name',
        'price',
        'calories',
        'in_stock'
    ];

    public static function servedAt()
    {
        return  Self::select('serving_at')->distinct('serving_at')->get();
    }
        
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function kitchen(): BelongsTo
    {
        return $this->belongsTo(Kitchen::class);
    }

        public static function codes(): Collection
        {
            return collect(
                [
                    ['code' => 0,  'label' => 'Best before'],
                    ['code' => 1,  'label' => 'Expiring'],
                    ['code' => 2, 'label'  => 'Expired'],
                ]
            );
        }
}
