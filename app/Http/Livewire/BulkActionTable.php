<?php

namespace App\Http\Livewire;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class BulkActionTable extends PowerGridComponent
{
    use ActionButton;

    //Table sort field
    public string $sortField = 'dishes.id';

    /*
    |--------------------------------------------------------------------------
    |  Event listeners
    |--------------------------------------------------------------------------
    | Add custom events to DishesTable
    |
    */
    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'edit-dish' => 'editDish',
                'bulkDelete-'.$this->tableName => 'bulkDelete',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    |  Bulk delete button
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(): void
    {
        $this->emit('openModal', 'delete-dish', [
            'dishIds' => $this->checkboxValues,
            'confirmationTitle' => 'Delete dish',
            'confirmationDescription' => 'Are you sure you want to delete this dish?',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Edit Dish button
    |--------------------------------------------------------------------------
    */

    public function editDish(array $data): void
    {
        dd('You are editing', $data);
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
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

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return  Builder<Dish>|null
     */
    public function datasource()
    {
        return Dish::query()
            ->join('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->join('kitchens', function ($categories) {
                $categories->on('dishes.kitchen_id', '=', 'kitchens.id');
            })
            ->select('dishes.*', 'categories.name as category_name', DB::raw('DATE_FORMAT(dishes.produced_at, "%d/%m/%Y") as produced_at_formatted'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('serving_at')
            ->addColumn('chef_name')
            ->addColumn('dish_name', function (Dish $dish) {
                return $dish->name;
            })
            ->addColumn('calories', function (Dish $dish) {
                return $dish->calories.' kcal';
            })
            ->addColumn('category_id', function (Dish $dish) {
                return $dish->category_id;
            })
            ->addColumn('category.name')
            ->addColumn('kitchen_id', function (Dish $dish) {
                return $dish->kitchen_id;
            })
            ->addColumn('kitchen.description')
            ->addColumn('price')
            ->addColumn('price_BRL', function (Dish $dish) {
                return 'R$ '.number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })
            ->addColumn('sales_price')
            ->addColumn('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function (Dish $dish) {
                return $dish->in_stock ? 'sim' : 'não';
            })
            ->addColumn('diet', function (Dish $dish) {
                return Diet::from($dish->diet)->labels();
            })
            ->addColumn('produced_at')
            ->addColumn('produced_at_formatted');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
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
                ->clickToCopy(true)
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::add()
                ->title(__('Chef'))
                ->field('chef_name', 'dishes.chef_name')
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
                ->editOnClick(true)
                ->withSum('Total', true, true),

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

    /*
   |--------------------------------------------------------------------------
   | Header Action Buttons
   |--------------------------------------------------------------------------
   */

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->caption(__('Bulk delete (<span x-text="window.pgBulkActions.count(\''.$this->tableName.'\')"></span>)'))
                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emit('bulkDelete-'.$this->tableName, []),
        ];
    }

    /**
     * PowerGrid Dish Action Buttons.
     *
     * @return array<int, Button>
     */
    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption('Edit')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->emit('edit-dish', [
                    'dishId' => 'id',
                    'custom' => __METHOD__,
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class('bg-red-500 text-white px-3 py-2 m-1 rounded text-sm')
                ->openModal('delete-dish', [
                    'dishId' => 'id',
                    'confirmationTitle' => 'Delete dish',
                    'confirmationDescription' => 'Are you sure you want to delete this dish?',
                ]),
        ];
    }
}
