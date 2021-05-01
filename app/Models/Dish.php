<?php

namespace App\Models;

use App\Models\Kitchen;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id', 'category_id', 'name', 'price', 'calories', 'in_stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function getSalesPrice()
    {
        return $this->sales_price = $this->price + ($this->price * 0.15);
    }
}
