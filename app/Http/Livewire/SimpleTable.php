<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class SimpleTable extends PowerGridComponent
{
    use ActionButton;

    public string $tableName = 'simpleTable';

    public function setUp(): array
    {
        return [
            //            Cache::make()
            //                ->forever(),

            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        return Dish::with('category');
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('chef_name')
            ->addColumn('price', function (Dish $dish) {
                return (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))
                    ->formatCurrency($dish->price, 'USD');
            })
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function (Dish $dish) {
                if ($dish->in_stock) {
                    return Blade::render('Yes');
                }

                return Blade::render('No');
            })
            ->addColumn('created_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->created_at)
                    ->timezone('America/Sao_Paulo')->format('d/m/Y');
            });
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

            Column::make('Chef', 'chef_name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    #[On('execute')]
    public function execute(string $component, array $parameters = [])
    {
        dd(get_defined_vars());
    }

    public function actions(Dish $dish): array
    {
        return [
//            Button::add('edit')
//                ->slot('Edit: ' . $dish->id)
//                ->class('text-center'),

            //            Button::add('edit')
            //                ->slot('Edit: ' .$dish->id)
            //                ->id()
            //                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
            //                ->bladeComponent('select', []),
            //
            //            Button::add('edit')
            //                ->slot('Edit: ' .$dish->id)
            //                ->id()
            //                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
            //                ->openModal('execute', ['id' => $dish->id]),
//
//            Button::add('edit')
//                ->slot('Open Modal: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->openModal('execute', [
//                    'params' => ['id' => $dish->id],
//                ]),

            Button::make('dispatch')
                ->slot('dispatch: ' . $dish->id)
                ->dispatch('executeDispatch', ['id' => $dish->id]),
//
//            Button::make('call2')
//                ->slot('call: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->call('js', [
//                    'params' => ['id' => $dish->id],
//                ]),
//
//            Button::make('dispatch')
//                ->slot('dispatch: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->dispatch('execute', [
//                    'params' => ['id' => $dish->id],
//                ]),
//
//            Button::make('dispatchSelf')
//                ->slot('dispatchSelf: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->dispatchSelf('execute', [
//                    'params' => ['id' => $dish->id],
//                ]),
//
//            Button::make('dispatchTo')
//                ->slot('dispatchTo: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->dispatchTo('to','execute', [
//                    'params' => ['id' => $dish->id],
//                ]),
//
//            Button::make('parent')
//                ->slot('parent: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ->parent('openModal', [
//                    'params' => ['id' => $dish->id],
//                ]),
//
//            Button::make('toggleDetail')
//                ->slot('toggleDetail: '.$dish->id)
//                ->id($dish->id)
//                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
//                ,
        ];
    }

    public function actionRules(Dish $dish): array
    {
       return [
           Rule::button('dispatch')
               ->when(fn ($dish) => $dish->id == 3)
               ->disable()
//
//           Rule::button('call')
//               ->when(fn (Dish $dish) => $dish->id == 1)
//               ->setAttribute('class', 'asdasd')
//               ->bladeComponent('livewire-powergrid::icons.arrow', [
//                   'dish-id' => $dish->id,
//                   'class' => 'w-5'
//               ]),
//
//           Rule::button('call2')
//               ->when(fn (Dish $dish) => $dish->id == 1)
//               ->bladeComponent('livewire-powergrid::icons.arrow', ['dish-id' => $dish->id]),
//
//           Rule::button('call2')
//               ->when(fn (Dish $dish) => $dish->id === 1)
//               ->setAttribute('class', 'bg-pg-primary-200')
//               ->setAttribute('title', 'Title changed by setAttributes when id 2')
//               ->setAttribute('wire:click', ['test', ['param1' => 2, 'dishId' => 'id']]),
////
//           Rule::button('call1')
//               ->when(function ($dish) {
//                   return $dish->id === 1;
//               })
//               ->emit('asdasd', [])
//               ->setAttribute('class', 'bg-red-500')
//               ->setAttribute('id', 'new-id'),
//
//           Rule::button('dispatch')
//               ->when(function ($dish) {
//                   return $dish->id === 1;
//               })
//               ->setAttribute('class', 'bg-red-300'),
       ];
    }
}
