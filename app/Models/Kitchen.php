<?php

namespace App\Models;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kitchen extends Model
{
    use HasFactory;

    public function dishes()
    {
        return $this->hasMany(Dish::class, "category_id");
    }

}
