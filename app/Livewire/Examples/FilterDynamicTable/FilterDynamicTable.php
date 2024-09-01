<?php

namespace App\Livewire\Examples\FilterDynamicTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class FilterDynamicTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Dish::with(['category', 'kitchen']);
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category_name', fn ($dish) => e($dish->category->name));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Dish', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::dynamic('category_name', 'category_id')
                ->component('select')
                ->attributes([
                    'async-data'      => route('category.index'),
                    'option-label'    => 'name',
                    'multiselect'     => false,
                    'option-value'    => 'id',
                    'wire:model.blur' => 'filters.select.category_id',
                    'placeholder'     => 'Select a category',
                ]),
        ];
    }
}
