<?php

namespace App\Livewire\Examples\FilterDynamicTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class FilterDynamicTable extends PowerGridComponent
{
    public int $categoryId = 0;

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }

    public function setUp(): array
    {
        $this->showCheckBox('id');

        return [

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Dish::query()
            ->when(
                $this->categoryId,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->categoryId)
                )
                    ->with(['category', 'kitchen'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],

            'chef' => [
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
                ]),
        ];
    }
}