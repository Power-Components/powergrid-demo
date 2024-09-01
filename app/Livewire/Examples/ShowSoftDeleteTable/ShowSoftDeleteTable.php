<?php

namespace App\Livewire\Examples\ShowSoftDeleteTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ShowSoftDeleteTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::with('category')->whereBetween('id', [40, 45]);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('in_stock')
            ->add('in_stock_label', fn ($entry) => $entry->in_stock ? 'Yes' : 'No')
            ->add('created_at', fn ($entry) => Carbon::parse($entry->created_at))
            ->add('created_at_formatted', fn ($entry) => Carbon::parse($entry->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::rows()
                ->when(fn ($dish) => $dish->trashed())
                ->setAttribute('class', 'bg-red-200'),
        ];
    }
}
