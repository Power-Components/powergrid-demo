<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class JoinTable extends PowerGridComponent
{
    use ActionButton;

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage(8, [8, 15, 25]),
        ];
    }

    public function dataSource(): Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name');
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('dish_name', fn (Dish $dish) => $dish->name)
            ->addColumn('category_name', fn (Dish $dish) => $dish->category->name);
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Dish', 'dish_name', 'dishes.name')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name', 'newCategories.name')
                ->searchable()
                ->sortable(),
        ];
    }
}
