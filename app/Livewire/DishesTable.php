<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

class DishesTable extends PowerGridComponent
{
    public bool $filtersOutside = false;

    public string $sortField = 'dishes.id';

    public bool $ableToLoad = false;

    public string $loadingComponent = 'components.my-custom-loading';

    public function onUpdatedToggleable($id, $field, $value): void
    {
        Dish::query()->where('id', $id)->update([
            $field => $value,
        ]);

        $this->skipRender();
    }

    #[On('bulkDelete')]
    public function bulkDelete(): void
    {
        $this->dispatch('openModal', 'delete-dish', [
            'dishIds' => $this->checkboxValues,
            'confirmationTitle' => 'Delete dish',
            'confirmationDescription' => 'Are you sure you want to delete this dish?',
        ]);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name')
            ->toBase();
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('serving_at')
            ->addColumn('chef_name')
            ->addColumn('dish_name', function ($dish) {
                return $dish->name;
            })
            ->addColumn('calories', function ($dish) {
                return $dish->calories.' kcal';
            })
            ->addColumn('category_id', function ($dish) {
                return $dish->category_id;
            })
            ->addColumn('category_name', function ($dish) {
                return $dish->category_name;
            })
            /*** PRICE ***/
            ->addColumn('price')
            ->addColumn('price_BRL', function ($dish) {
                return 'R$ '.number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })

            /*** SALE'S PRICE ***/
            ->addColumn('sales_price')
            ->addColumn('sales_price_BRL', function ($dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })

            /*** STOCK ***/
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function ($dish) {
                return $dish->in_stock ? 'sim' : 'não';
            })

            ->addColumn('diet', function ($dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })

            /*** Produced At ***/
            ->addColumn('produced_at')
            ->addColumn('produced_at_formatted', function ($dish) {
                return Carbon::parse($dish->produced_at)->format('d/m/Y');
            });
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
                ->contentClasses('!whitespace-normal')
                ->placeholder('placeholder')
                ->sortable(),

            Column::add()
                ->field('diet', 'dishes.diet')
                ->title(__('Diet')),

            Column::add()
                ->title(__('Category'))
                ->field('category_name', 'categories.name')
                ->placeholder('Category placeholder'),

            Column::add()
                ->title(__('Price'))
                ->field('price_BRL')
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
                ->field('kitchen_name', 'kitchen_id')
                ->sortable(),

            Column::add()
                ->title(__('Production date'))
                ->field('produced_at_formatted'),

            Column::action('Action')
                ->fixedOnResponsive(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot(__('Bulk delete'))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete', []),
        ];
    }

    public function actions($dish): array
    {
        return [
            Button::add('edit-stock')
                ->slot('edit')
                ->openModal('edit-stock', ['dishId' => $dish->id]),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn ($dish) => $dish->id == 2)
                ->setAttribute('class', 'bg-green-200')
                ->setAttribute('wire:click', ['test', ['param1' => 1, 'dishId' => 'id']]),

            Rule::button('destroy')
                ->when(fn ($dish) => $dish->id == 1)
                ->slot('Delete #1'),

            Rule::checkbox()
                ->when(fn ($dish) => $dish->id == 2)
                ->hide(),

            Rule::rows()
                ->when(fn ($dish) => (bool) $dish->in_stock === false)
                ->setAttribute('class', 'bg-yellow-50 hover:bg-yellow-100'),
        ];
    }
}
