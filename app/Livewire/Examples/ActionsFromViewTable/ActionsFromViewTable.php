<?php

namespace App\Livewire\Examples\ActionsFromViewTable;

use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class ActionsFromViewTable extends PowerGridComponent
{
    public string $tableName = 'actions-from-view-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
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

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category_name', fn ($dish) => e($dish->category_name))
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('in_stock', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Dish Name', 'name')
                ->bodyAttribute('!text-wrap')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price_in_eur', 'price'),

            Column::make('In Stock', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    public function actionsFromView($row): View
    {
        return view('actions-view', ['row' => $row]);
    }
}
