<?php

namespace App\Livewire;

use App\Models\Dish;
use PowerComponents\LivewirePowerGrid\Button;

class ExtendButtonTable extends SimpleTable
{
    public function actions(Dish $dish): array
    {
        return [
            Button::add('edit')
                ->icon('pencil')
                ->route('advices.edit', ['advice' => $dish->id]),

            Button::add('edit')
                ->icon('trash', ['class' => 'text-red-500 dark:text-red-400'])
                ->route('advices.edit', ['advice' => $dish->id]),
        ];
    }
}
