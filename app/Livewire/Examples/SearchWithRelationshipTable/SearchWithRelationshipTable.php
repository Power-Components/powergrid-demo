<?php

namespace App\Livewire\Examples\SearchWithRelationshipTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class SearchWithRelationshipTable extends PowerGridComponent
{
    public string $tableName = 'search-with-relationship-table';

    public int $categoryId = 0;

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
            ->add('chef_name', fn ($dish) => e($dish->chef?->name))
            ->add('category_name', fn ($dish) => e($dish->category->name))
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
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

            Column::make('Category', 'category_name')
                ->searchable(),

            Column::make('Chef', 'chef_name')
                ->searchable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }
}
