<?php

namespace App\Livewire\Examples\NoResultsFoundTable;

use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class NoResultsFoundTable extends PowerGridComponent
{
    public function noDataLabel(): string|View
    {
        //return 'We could not find any dish matching your search.';
        return view('dishes.no-data');
    }

    public function datasource(): ?Builder
    {
        return Dish::query()->where('id', 0)->toBase();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('Name', 'name'),
        ];
    }
}
