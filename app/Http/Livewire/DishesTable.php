<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class DishesTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    //Table sort field
    public string $sortField = 'dishes.id';

    /*
    |--------------------------------------------------------------------------
    |  Custom Theme - ❤️‍🔥 BIG FONTS LOVERS
    |--------------------------------------------------------------------------
    | PowerGrid allows you to create custom themes.
    |
    | Uncomment if you love BIG fonts
    |
    */

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
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount('min'),

            Detail::make()
                ->view('components.detail') // views/components.detail.blade.php
                ->options(['message' => 'hello world'])
                ->showCollapseIcon(),
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
     * @return Builder<\App\Models\Dish|null>
     */
    public function datasource(): Builder
    {
        return Dish::query()
            ->join('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->join('kitchens', function ($categories) {
                $categories->on('dishes.kitchen_id', '=', 'kitchens.id');
            })
            /** Many to Many Relationship **/
            ->leftJoin('dish_restaurant', 'dishes.id', '=', 'dish_restaurant.dish_id')
            ->leftJoin('restaurants', 'restaurants.id', '=', 'dish_restaurant.restaurant_id')
            ->with([
                'restaurants',
            ])
            ->select('dishes.*', 'categories.name as category_name')
            ->groupBy('dishes.id');
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
            'restaurants' => [
                'title',
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
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        /****
         * ❗ IMPORTANT: You must use the function e() to escape
         *    values coming from the database in closures.
         */
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('serving_at')
            ->addColumn('chef_name')
            ->addColumn('dish_name', function (Dish $dish) {
                return e($dish->name);
            })
            ->addColumn('calories', function (Dish $dish) {
                return e($dish->calories).' kcal';
            })
            ->addColumn('category_id', function (Dish $dish) {
                return e($dish->category_id);
            })
            ->addColumn('category_name', function (Dish $dish) {
                return e($dish->category->name);
            })

            /*** KITCHEN ***/
            ->addColumn('kitchen_id', function (Dish $dish) {
                return e($dish->kitchen_id);
            })
            ->addColumn('kitchen_name', function (Dish $dish) {
                return e($dish->kitchen->name);
            })

            /*** CODE ***/
            ->addColumn('code_label', fn ($dish) => e(Dish::codes()->firstWhere('code', $dish->code)['label']))

            /*** RESTAURANTS ***/
            ->addColumn('restaurant_title', fn ($dish) => $dish->restaurants->pluck('title')->map(fn ($title) => e($title))->implode(', '))

            /*** PRICE ***/
            ->addColumn('price')
            ->addColumn('price_BRL', function (Dish $dish) {
                return 'R$ '.number_format(e($dish->price), 2, ',', '.'); //R$ 1.000,00
            })

            /*** SALE'S PRICE ***/
            ->addColumn('sales_price')
            ->addColumn('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format(e($sales_price), 2, ',', '.'); //R$ 1.000,00
            })
            /*** STOCK ***/
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function (Dish $dish) {
                return $dish->in_stock ? 'sim' : 'não';
            })
            ->addColumn('diet', function (Dish $dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })
            /*** Produced At ***/
            ->addColumn('produced_at')
            ->addColumn('produced_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->produced_at)->format('d/m/Y');
            });
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
        $canEdit = true; //Has permission to edit. E,g, $user->can('edit');

        return [

            Column::make('Id', 'id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::make(__('Dish'), 'dish_name', 'dishes.name')
                ->searchable()
                ->editOnClick($canEdit)
                ->clickToCopy(true)
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::make(__('Chef'), 'chef_name', 'dishes.chef_name')
                ->searchable()
                ->placeholder('Chef placeholder')
                ->sortable(),

            Column::make(__('Diet'), 'diet', 'dishes.diet'),

            Column::make(__('Category'), 'category_name', 'categories.name')
                ->placeholder('Category placeholder')
                ->sortable(),

            Column::make('Serving at', 'serving_at')
                ->sortable(),

            Column::make('Restaurant', 'restaurant_title', 'restaurants.title'),

            Column::make(__('Price'), 'price_BRL')
                ->editOnClick($canEdit)
                ->withSum('Total', true, true),

            Column::make('Code', 'code_label', 'code'),

            Column::make(__('Sales price'), 'sales_price_BRL'),

            Column::make(__('Calories'), 'calories')
                ->sortable(),

            Column::make(__('In Stock'), 'in_stock')
                ->toggleable(true, 'yes', 'no')
                ->headerAttribute('', 'width: 100px;')
                ->sortable(),

            Column::make(__('Kitchen'), 'kitchen_name', 'kitchens.name')
                ->sortable('kitchens.name'),

            Column::make(__('Production date'), 'produced_at_formatted'),
        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [

            Filter::number('price', 'price_in_brl')
                ->thousands('.')
                ->decimal(','),

            Filter::number('price', 'price_in_brl')
                ->thousands('.')
                ->decimal(','),

            Filter::number('calories'),

            Filter::inputText('dish_name', 'dishes.name')
                ->operators(['contains', 'is', 'is_not']),

            Filter::inputText('chef_name', 'dishes.chef_name'),

            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(\App\Enums\Diet::cases())
                ->optionLabel('dishes.diet'),

            Filter::multiSelect('category_name', 'category_id')
                ->dataSource(Category::all())
                ->optionValue('id')
                ->optionLabel('name'),

            Filter::datepicker('produced_at_formatted', 'produced_at')
                ->params(['timezone' => 'America/Sao_Paulo']),

            Filter::boolean('in_stock')
                ->label('yes', 'no'),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->caption(__('Bulk delete'))
                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emit('bulkDelete', []),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Dish Action Buttons.
     *
     * @return array<int, Button>
     */
    public function actions(): array
    {
        $theme = config('livewire-powergrid.theme');

        $edit = ($theme == 'tailwind') ? 'bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm' : 'btn btn-primary';

        $delete = ($theme == 'tailwind') ? 'bg-red-500 text-white px-3 py-2 m-1 rounded text-sm' : 'btn btn-danger';

        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class($edit)
                ->emit('edit-dish', [
                    'dishId' => 'id',
                    'custom' => __METHOD__,
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class($delete)
                ->openModal('delete-dish', [
                    'dishId' => 'id',
                    'confirmationTitle' => 'Delete dish',
                    'confirmationDescription' => 'Are you sure you want to delete this dish?',
                ]),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Dish Action Rules.
     *
     * @return array<int, RuleActions>
     */
    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn ($dish) => $dish->id == 1)
                ->hide(),

            Rule::button('destroy')
                ->when(fn ($dish) => $dish->id == 1)
                ->caption('Delete #1'),

            Rule::checkbox()
                ->when(fn ($dish) => $dish->id == 2)
                ->hide(),

            Rule::rows()
                ->when(fn ($dish) => (bool) $dish->in_stock === false)
                ->setAttribute('class', 'bg-yellow-50 hover:bg-yellow-100'),
        ];
    }

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
            parent::getListeners(), [
                'edit-dish' => 'editDish',
                'bulkDelete',
            ]);
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
}
