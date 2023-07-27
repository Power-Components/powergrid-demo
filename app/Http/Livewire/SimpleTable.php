<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Cache;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class SimpleTable extends PowerGridComponent
{
    use ActionButton;

    public string $tableName = 'simpleTable';

    public function setUp(): array
    {
        return [
//            Cache::make()
//                ->forever(),

            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        return Dish::with('category');
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('chef_name')
            ->addColumn('price', function (Dish $dish) {
                return (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))
                    ->formatCurrency($dish->price, 'USD');
            })
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function (Dish $dish) {
                if ($dish->in_stock) {
                    return Blade::render('Yes');
                }

                return Blade::render('No');
            })
            ->addColumn('created_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->created_at)
                    ->timezone('America/Sao_Paulo')->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Chef', 'chef_name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }
}
