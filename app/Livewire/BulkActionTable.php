<?php

namespace App\Livewire;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class BulkActionTable extends PowerGridComponent
{
    public string $sortField = 'dishes.id';

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        $this->js('alert(window.pgBulkActions.get(\''.$this->tableName.'\'))');
    }

    public function editDish(array $data): void
    {
        dd('You are editing', $data);
    }

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

    public function datasource()
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
            ->select('dishes.*', 'categories.name as category_name', DB::raw('DATE_FORMAT(dishes.produced_at, "%d/%m/%Y") as produced_at_formatted'));
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
            ->add('chef_name', function (Dish $dish) {
                return $dish->chef?->name ?? '-';
            })
            ->add('dish_name', function (Dish $dish) {
                return $dish->name;
            })
            ->add('calories', function (Dish $dish) {
                return $dish->calories.' kcal';
            })
            ->add('category_id', function (Dish $dish) {
                return $dish->category_id;
            })
            ->add('category.name')
            ->add('kitchen_id', function (Dish $dish) {
                return $dish->kitchen_id;
            })
            ->add('kitchen.description')
            ->add('price')
            ->add('price_BRL', function (Dish $dish) {
                return 'R$ '.number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })
            ->add('sales_price')
            ->add('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })
            ->add('in_stock')
            ->add('in_stock_label', function (Dish $dish) {
                return $dish->in_stock ? 'yes' : 'no';
            })
            ->add('diet', function (Dish $dish) {
                return Diet::from($dish->diet)->labels();
            })
            ->add('produced_at')
            ->add('produced_at_formatted');
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title(__('ID'))
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title(__('Dish'))
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->editOnClick(true)
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::add()
                ->title(__('Chef'))
                ->field('chef_name', 'chefs.name')
                ->searchable()
                ->placeholder('Chef placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->title(__('Diet')),

            Column::add()
                ->title(__('Category'))
                ->field('category.name')
                ->placeholder('Category placeholder')
                ->sortable(),

            Column::add()
                ->title(__('Price'))
                ->field('price')
                ->editOnClick(true),

            Column::add()
                ->title(__('Sales price'))
                ->field('sales_price_BRL'),

            Column::add()
                ->title(__('Calories'))
                ->field('calories')
                ->sortable(),

            Column::add()
                ->title(__('In Stock'))
                ->field('in_stock')
                ->toggleable(true, 'yes', 'no')
                ->sortable(),

            Column::add()
                ->title(__('Kitchen'))
                ->field('kitchen.description')
                ->sortable(),

            Column::add()
                ->title(__('Production date'))
                ->field('produced_at_formatted')
                ->sortable(),
            //  ->searchableRaw('DATE_FORMAT(dishes.produced_at, "%d/%m/%Y")'),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot(__('Bulk delete (<span x-text="window.pgBulkActions.count(\''.$this->tableName.'\')"></span>)'))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete.'.$this->tableName, []),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::number('price')->thousands(','),
        ];
    }
}
