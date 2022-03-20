<?php

namespace App\Http\Livewire;

use App\Http\Enums\Diet;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Kitchen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'edit-dish' => 'editDish',
                'bulkDelete',
            ]);
    }

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public string $sortField = 'dishes.id';

    public function bulkDelete()
    {
        $this->emit('openModal', 'delete-dish', [
            'dishIds'                 => $this->checkboxValues,
            'confirmationTitle'       => 'Delete dish',
            'confirmationDescription' => 'Are you sure you want to delete this dish?',
        ]);
    }

    public function editDish(array $data)
    {
        dd($data);
    }

    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
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
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
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
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('dish_name', function (Dish $dish) {
                return $dish->name;
            })
            ->addColumn('chef_name')
            ->addColumn('calories')
            ->addColumn('diet', function (Dish $dish) {
                return Diet::from($dish->diet)->labels();
            })
            ->addColumn('calories', function (Dish $dish) {
                return $dish->calories . ' kcal';
            })
            /*** CATEGORY ***/
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
            /*** Produced At ***/
            ->addColumn('produced_at')
            ->addColumn('produced_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->produced_at)->format('d/m/Y');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Column>
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

            Column::add()
                ->field('diet', 'dishes.diet')
                ->makeInputEnumSelect(Diet::cases(), 'dishes.diet')
                ->title(__('Dieta')),

            Column::add()
                ->title(__('Category'))
                ->field('category_name', 'categories.name')
                ->placeholder('Category placeholder')
                ->makeInputMultiSelect(Category::all(), 'name', 'category_id')
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
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
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

    /**
     * PowerGrid Dish action buttons.
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
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
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

    /**
     * PowerGrid Dish Update.
     *
     * @param array<string,string> $data
     */
    public function update(array $data): bool
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
    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

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
