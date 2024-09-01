<?php

namespace App\Livewire\Examples\DatasourceRelationshipTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class DatasourceRelationshipTable extends PowerGridComponent
{
    public function datasource(): ?Builder
    {
        return Dish::query()->with('kitchen');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('kitchen_description', fn ($dish) => e($dish->kitchen->description));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Kitchen', 'kitchen_description'),
        ];
    }
}
