<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Kitchen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class DishesTable extends PowerGridComponent
{
    use ActionButton;

    public function setUp()
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showRecordCount()
            ->showToggleColumns()
            ->showExportOption('download', ['excel', 'csv'])
            ->showSearchInput();
    }

    public function dataSource(): ?Builder
    {
        return Dish::query()->with('kitchen', 'category');
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name'
            ]
        ];
    }

    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('calories')
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

    public function columns(): array
    {
        $canEdit = true; //Permissão pra editar

        return [
            Column::add()
                ->title(__('ID'))
                ->field('id')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title(__('Prato'))
                ->field('name')
                ->searchable()
                ->editOnClick($canEdit)
                ->clickToCopy(true)
                ->makeInputText('name')
                ->sortable(),

            Column::add()
                ->title(__('Categoria'))
                ->field('category_name')
                ->makeInputMultiSelect(Category::all(), 'name', 'category_id'),

            Column::add()
                ->title(__('Preço'))
                ->field('price_BRL')
                ->editOnClick($canEdit)
                ->makeInputRange('price', ".", ","),

            Column::add()
                ->title(__('Preço de Venda'))
                ->field('sales_price_BRL'),

            Column::add()
                ->title(__('Calorias'))
                ->field('calories')
                ->makeInputRange('calories')
                ->sortable(),

            Column::add()
                ->title(__('Em Estoque'))
                ->toggleable(true, 'sim', 'não')
                ->makeBooleanFilter('in_stock', 'sim', 'não')
                ->field('in_stock'),

            Column::add()
                ->title(__('Cozinha'))
                ->field('kitchen_name')
                ->sortable()
                ->makeInputMultiSelect(Kitchen::all(), 'name', 'kitchen_id'),

            Column::add()
                ->title(__('Data de produção'))
                ->field('produced_at_formatted')
                ->makeInputDatePicker('produced_at')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */
    public function actions(): array
    {
        $btnEditClass   = (powerGridTheme() === 'PowerComponents\LivewirePowerGrid\Themes\Tailwind') ? 'bg-indigo-500 text-white p-1 m-1 rounded text-sm' : 'btn btn-primary';
        $btnDeleteClass = (powerGridTheme() === 'PowerComponents\LivewirePowerGrid\Themes\Tailwind') ? 'bg-red-500 p-1 m-1 text-white text-sm' : 'btn btn-danger';

        return [
            Button::add('edit')
                ->caption(__('Editar'))
                ->class($btnEditClass)
                ->openModal('edit-dish', ['dishId' => 'id']),

            Button::add('destroy')
                ->caption(__('Deletar'))
                ->class($btnDeleteClass)
                ->route('dish.destroy', ['dish' => 'id'])
                ->method('delete')
        ];
    }

    public function header(): array
    {
        return [
            Button::add('new')
                ->caption(__('Action 1'))
                ->class('')
                ->emit('event', []),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods
    |
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
            $updated = Dish::query()->find($data['id'])->update([
                $data['field'] => $data['value']
            ]);
        } catch (QueryException $exception) {
            $updated = false;
        }

        return $updated;
    }

    public function updateMessages(string $status, string $field = '_default_message'): string
    {
        $updateMessages = [
            'success' => [
                '_default_message' => __('Data has been updated successfully!'),
                'price_BRL'        => __('Preço alterado'),
                //'custom_field' => __('Custom Field updated successfully!'),
            ],
            "error" => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field' => __('Error updating custom field.'),
            ]
        ];

        return ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);
    }
}
