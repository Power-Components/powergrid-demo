<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

class SimpleTable extends PowerGridComponent
{
    public string $tableName = 'simpleTable';

    public function setUp(): array
    {
        return [
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
            ->addColumn('category_id', function ($dish) {
                return $dish->category_id;
            })
            ->addColumn('category_name', function (Dish $dish) {
                return $dish->category->name;
            })
            ->addColumn('price_fmt', function (Dish $dish) {
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
                ->bodyAttribute('!text-wrap') // <--- add "!"
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Chef', 'chef_name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('Price', 'price_fmt')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit(int $dishId): void
    {
        $this->js('alert('.$dishId.')');
    }

    public function actions(Dish $dish): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$dish->id)
                ->id()
                ->class('cursor-pointer block bg-white text-sm text-gray-700 border border-gray-300 rounded py-1.5 px-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->dispatch('edit', ['dishId' => $dish->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [

            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn ($row) => $row->id == 1)
                ->hide(),
        ];
    }
}
