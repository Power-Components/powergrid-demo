<?php

namespace App\Livewire\Examples\BulkActionsTable;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class BulkActionsTable extends PowerGridComponent
{
    public string $sortField = 'dishes.id';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
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
            ->add('serving_at')
            ->add('chef_name', fn ($dish) => e($dish->chef?->name))
            ->add('dish_name', fn ($dish) => e($dish->name))
            ->add('calories', fn ($dish) => e($dish->calories) . ' kcal')
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category.name')
            ->add('kitchen_id', fn ($dish) => intval($dish->kitchen_id))
            ->add('kitchen.description')
            ->add('price')
            ->add('price_BRL', fn ($dish) => Number::currency($dish->price, in: 'BRL'))
            ->add('sales_price')
            ->add('sales_price_BRL', fn ($dish) => Number::currency($dish->price + ($dish->price * 0.15), in: 'BRL'))
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
                ->field('id', 'dishes.id')
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
                ->title('Chef')
                ->field('chef_name', 'chefs.name')
                ->searchable()
                ->placeholder('Chef placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->title('Diet'),

            Column::add()
                ->title('Category')
                ->field('category.name')
                ->placeholder('Category placeholder')
                ->sortable(),

            Column::add()
                ->title('Price')
                ->field('price')
                ->editOnClick(hasPermission: true),

            Column::add()
                ->title('Sales price')
                ->field('sales_price_BRL'),

            Column::add()
                ->title('Calories')
                ->field('calories')
                ->sortable(),

            Column::add()
                ->title('In Stock')
                ->field('in_stock')
                ->toggleable(hasPermission: true, trueLabel: 'yes', falseLabel: 'no')
                ->sortable(),

            Column::add()
                ->title('Kitchen')
                ->field('kitchen.description')
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
