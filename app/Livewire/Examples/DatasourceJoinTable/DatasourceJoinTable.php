<?php

namespace App\Livewire\Examples\DatasourceJoinTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class DatasourceJoinTable extends PowerGridComponent
{
    public string $tableName = 'datasource-join-table';

    public ?string $primaryKeyAlias = 'id';

    public string $primaryKey = 'dishes.id';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(8, [8, 15, 25]),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('category')
            ->add('name')
            ->add('category_name');
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

            Column::make('Category', 'category_name', 'category_name')
                ->searchable()
                ->sortable(),
        ];
    }
}
