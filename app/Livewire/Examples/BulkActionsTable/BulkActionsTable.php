<?php

namespace App\Livewire\Examples\BulkActionsTable;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class BulkActionsTable extends PowerGridComponent
{
    public ?string $primaryKeyAlias = 'id';

    public string $sortField = 'dishes.id';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot('Bulk delete (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete.' . $this->tableName, []),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->leftJoin('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->leftJoin('kitchens', function ($categories) {
                $categories->on('dishes.kitchen_id', '=', 'kitchens.id');
            })
            ->leftJoin('chefs', function ($categories) {
                $categories->on('dishes.chef_id', '=', 'chefs.id');
            })
            ->select('dishes.*', 'categories.name as category_name');
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
            ->add('in_stock')
            ->add('in_stock_label', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('diet', fn ($dish) => Diet::from($dish->diet)->labels())
            ->add('produced_at')
            ->add('produced_at_formatted', fn ($dish) => Carbon::parse($dish->produced_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Dish')
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->editOnClick(hasPermission: true)
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::add()
                ->title('In Stock')
                ->field('in_stock')
                ->toggleable(hasPermission: true, trueLabel: 'yes', falseLabel: 'no')
                ->sortable(),

            Column::add()
                ->title('Production date')
                ->field('produced_at_formatted', 'produced_at'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::number('price')->thousands(','),
        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        $this->js('alert(window.pgBulkActions.get(\'' . $this->tableName . '\'))');
    }

    public function editDish(array $data): void
    {
        dd('You are editing', $data);
    }
}
