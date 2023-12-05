<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Database\Query\Builder;
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

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name')
            ->toBase();
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('category_id', function ($dish) {
                return $dish->category_id;
            })
            ->addColumn('category_name', function ($dish) {
                return $dish->category_name;
            })
            ->addColumn('price_fmt', function ($dish) {
                return (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))
                    ->formatCurrency($dish->price, 'USD');
            })
            ->addColumn('in_stock', function ($dish) {
                return $dish->in_stock ? 'Yes' : 'No';
            })
            ->addColumn('created_at_formatted', function ($dish) {
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
                ->bodyAttribute('!text-wrap')
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

    public function actions($dish): array
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
