<?php

namespace App\Livewire\Examples\DishesDetailRowTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class DishesDetailRowTable extends PowerGridComponent
{
    public string $tableName = 'dishes-detail-row-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(5)
                ->showRecordCount(),

            PowerGrid::detail()
                ->view('components.detail')
                ->params(['name' => 'Luan'])
                ->showCollapseIcon(),
        ];
    }

    public function datasource(): ?Builder
    {
        return $this->query();
    }

    public function query(): Builder
    {
        return Dish::with('category');
    }

    public function join(): Builder
    {
        return Dish::query()
            ->join('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->select('dishes.*', 'categories.name as category_name');
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
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::action('Action'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::make('toggleDetail', 'Click to Toggle Detail')
                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
                ->toggleDetail($row->id),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::rows()
                ->when(fn ($dish) => $dish->id == 1)
                ->detailView('components.detail-rules', ['fromActionRule' => true]),
        ];
    }
}
