<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class SummarizeTable extends PowerGridComponent
{
    public string $tableName = 'simpleTable';

    public string|int $selectedCategoryId = '';

    public function setUp(): array
    {
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
        return Dish::with('category');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('category_name', function (Dish $dish) {
                return $dish->category->name;
            })
            ->add('price_fmt', function (Dish $dish) {
                return (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))
                    ->formatCurrency($dish->price, 'USD');
            })
            ->add('in_stock')
            ->add('in_stock_label', function (Dish $dish) {
                if ($dish->in_stock) {
                    return Blade::render('Yes');
                }

                return Blade::render('No');
            })
            ->add('created_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->created_at)
                    ->timezone('America/Sao_Paulo')->format('d/m/Y');
            });
    }

    public function summarizeFormat(): array
    {
        return [
            'price.{sum,avg}' => function ($value) {
                return (new \NumberFormatter('en_US', \NumberFormatter::CURRENCY))
                    ->formatCurrency($value, 'USD');
            },
            'price.{count,min,max}' => fn ($value) => $value,
        ];
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

            Column::make('Category', 'category_name'),

            Column::make('Price', 'price')
                ->withSum('Sum Price', true, false)
                ->withCount('Count Price', true, false)
                ->withAvg('Avg Price', true, false)
                ->withMin('Min Price', false, true)
                ->withMax('Max Price', false, true)
                ->sortable(),

            Column::make('Price', 'price_fmt')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    #[On('event')]
    public function event(string $dishId)
    {
        dd($dishId);
    }

    public function actions(Dish $dish): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$dish->id)
                ->id()
                ->class('cursor-pointer block bg-white text-sm text-gray-700 border border-gray-300 rounded py-1.5 px-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->dispatch('event', ['dishId' => $dish->id])
                ->hideWhen(fn () => $dish->id === 2),
        ];
    }
}
