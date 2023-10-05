<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
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
            ->addColumn('in_stock', function (Dish $dish) {
                return $dish->in_stock ? 'Yes' : 'No';
            })
            ->addColumn('created_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->created_at)
                    ->timezone('America/Sao_Paulo')->format('d/m/Y');
            });
    }

    public function beforeSearch(string $field = null, string $search = null): ?string
    {
        if ($field === 'in_stock') {
            return str(strtolower($search))
                ->replace('no', '0')
                ->replace('yes', '1')
                ->toString();
        }

        return $search;
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

            Column::make('Price', 'price_fmt', 'price')
                ->searchable()
                ->sortable(),

            Column::make('In Stock', 'in_stock')
                ->searchable(),

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
                ->bladeComponent('button.circle', [
                    'primary' => true,
                    'icon' => 'pencil',
                ])
                ->id()
                ->dispatch('edit', ['dishId' => $dish->id]),
        ];
    }
}
