<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    public $table = 'restaurants';

    protected $fillable = [
        'title',
    ];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }
}
