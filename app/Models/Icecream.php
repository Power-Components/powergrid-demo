<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icecream extends Model
{
    use HasFactory;

    protected $fillable = [
        'flavor',
        'in_stock',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'in_stock' => 'boolean',
        ];
    }
}
