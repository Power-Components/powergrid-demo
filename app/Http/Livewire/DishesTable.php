<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Kitchen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class DishesTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;
    
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
            'dishIds'                 => $this->checkboxValues,
            'confirmationTitle'       => 'Delete dish',
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
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Dish>|null
    */
    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'categories.id');
            })
            ->join('kitchens', function ($categories) {
                $categories->on('dishes.kitchen_id', '=', 'kitchens.id');
            })
            ->select('dishes.*', 'categories.name as category_name');
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
                'name'
            ]
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

    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('serving_at')
            ->addColumn('chef_name')
            ->addColumn('dish_name', function (Dish $dish) {
                return $dish->name;
            })
            ->addColumn('calories')
            ->addColumn('calories', function (Dish $dish) {
                return $dish->calories . ' kcal';
            })
            ->addColumn('category_id', function (Dish $dish) {
                return $dish->category_id;
            })
            ->addColumn('category_name', function (Dish $dish) {
                return $dish->category->name;
            })

            /*** KITCHEN ***/
            ->addColumn('kitchen_id', function (Dish $dish) {
                return $dish->kitchen_id;
            })
            ->addColumn('kitchen_name', function (Dish $dish) {
                return $dish->kitchen->name;
            })

            /*** PRICE ***/
            ->addColumn('price')
            ->addColumn('price_BRL', function (Dish $dish) {
                return 'R$ ' . number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })

            /*** SALE'S PRICE ***/
            ->addColumn('sales_price')
            ->addColumn('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ ' . number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })

            /*** STOCK ***/
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function (Dish $dish) {
                return ($dish->in_stock ? "sim" : "não");
            })

            /*** Only from Php 8.1
            ->addColumn('diet', function (Dish $dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })
            Only from Php 8.1 *******/

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
            Column::add()
                ->title(__('ID'))
                ->field('id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title(__('Dish'))
                ->field('dish_name', 'dishes.name')
                ->searchable()
                ->editOnClick($canEdit)
                ->clickToCopy(true)
                ->makeInputText()
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::add()
                ->title(__('Chef'))
                ->field('chef_name', 'dishes.chef_name')
                ->searchable()
                ->makeInputText()
                ->placeholder('Chef placeholder')
                ->sortable(),

            /*** Only from Php 8.1      
            Column::add()
                ->field('diet', 'dishes.diet')
                ->makeInputEnumSelect(\App\Enums\Diet::cases(), 'dishes.diet')
                ->title(__('Diet')),
            Only from Php 8.1 *******/

            Column::add()
                ->title(__('Category'))
                ->field('category_name', 'categories.name')
                ->placeholder('Category placeholder')
                ->makeInputMultiSelect(Category::all(), 'name', 'category_id')
                ->sortable(),

            Column::add()
                ->title('Serving at')
                ->field('serving_at')
                ->makeInputSelect(Dish::servedAt(), 'serving_at')
                //->MakeInputMultiSelect(Dish::select('serving_at')->distinct()->get(), 'serving_at')
                ->sortable(),

            Column::add()
                ->title(__('Price'))
                ->field('price_BRL')
                ->editOnClick($canEdit)
                ->makeInputRange('price', ".", ",")
                ->withSum('Total', true, true),
                
            Column::add()
                ->title(__('Sales price'))
                ->field('sales_price_BRL'),

            Column::add()
                ->title(__('Calories'))
                ->field('calories')
                ->makeInputRange('calories')
                ->sortable(),

            Column::add()
                ->title(__('In Stock'))
                ->field('in_stock')
                ->toggleable(true, 'yes', 'no')
                ->headerAttribute('', 'width: 100px;')
                ->makeBooleanFilter('in_stock', 'sim', 'não')
                ->sortable(),

            Column::add()
                ->title(__('Kitchen'))
                ->field('kitchen_name', 'kitchens.name')
                ->sortable('kitchens.name')
                ->makeInputMultiSelect(Kitchen::all(), 'name', 'kitchen_id'),

            Column::add()
                ->title(__('Production date'))
                ->field('produced_at_formatted')
                ->makeInputDatePicker('produced_at')
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
                ->caption(__('Bulk delete'))
                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emit('bulkDelete', [])
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
    * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
    */    
    public function actions(): array
    {
        $theme = config('livewire-powergrid.theme');

        $edit   = ($theme == 'tailwind') ? 'bg-indigo-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm' : 'btn btn-primary';

        $delete = ($theme == 'tailwind') ? 'bg-red-500 text-white px-3 py-2 m-1 rounded text-sm' : 'btn btn-danger';

        return [
            Button::add('edit')
                ->caption(__('Edit'))
                ->class($edit)
                ->emit('edit-dish', [
                    'dishId' => 'id',
                    'custom' => __METHOD__
                ]),

            Button::add('destroy')
                ->caption(__('Delete'))
                ->class($delete)
                ->openModal('delete-dish', [
                    'dishId'                  => 'id',
                    'confirmationTitle'       => 'Delete dish',
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
    * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
    */
    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn($dish) => $dish->id == 1)
                ->hide(),

            Rule::button('destroy')
                ->when(fn($dish) => $dish->id == 1)
                ->caption('Delete #1'),

            Rule::checkbox()
                ->when(fn($dish) => $dish->id == 2)
                ->hide(),

            Rule::rows()
                ->when(fn($dish) => (bool)$dish->in_stock === false)
                ->setAttribute('class', 'bg-yellow-50 hover:bg-yellow-100')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

    /**
    * PowerGrid Dish Update.
    *
    * @param array<string,string> $data
    */
    public function update(array $data ): bool
    {
        //Clean price_BRL R$ 4.947,70 --> 44947.70 and saves in database field 'price'

        if ($data['field'] == 'price_BRL') {
            $data['field'] = 'price';
            $data['value'] = Str::of($data['value'])
                ->replace('.', '')
                ->replace(',', '.')
                ->replaceMatches('/[^Z0-9\.]/', '');
        }

        try {
            $updated = Dish::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value']
                ]);
        } catch (QueryException $exception) {
            $updated = false;
        }

        return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success' => [
                '_default_message' => __('Data has been updated successfully!'),
                'price_BRL'        => 'Brazilian price changed!',
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
}
