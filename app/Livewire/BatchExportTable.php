<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class BatchExportTable extends PowerGridComponent
{
    use WithExport;

    public string $sortField = 'dishes.id';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->queues(6)
                ->onQueue('my-dishes')
                ->onConnection('redis'),

            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::with(['category:id,name', 'kitchen']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('serving_at')
            ->add('chef_name', function (Dish $dish) {
                return $dish->chef->name ?? '-';
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
                return \App\Enums\Diet::from($dish->diet)->labels();
            })

            ->add('produced_at')
            ->add('produced_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->produced_at)->format('d/m/Y');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id', 'dishes.id')
                ->searchable()
                ->sortable(),

            Column::make(__('Dish'), 'dish_name', 'dishes.name')
                ->searchable()
                ->placeholder('Dish placeholder')
                ->sortable(),

            Column::make(__('Chef'), 'chef_name', 'dishes.chef_name')
                ->searchable()
                ->placeholder('Chef placeholder')
                ->sortable(),

            Column::make('Diet', 'diet', 'dishes.diet'),

            Column::make(__('Category'), 'category.name')
                ->placeholder('Category place..'),

            Column::make(__('Price'), 'price_BRL'),

            Column::make(__('Sales price'), 'sales_price_BRL'),

            Column::make(__('Calories'), 'calories')
                ->sortable(),

            Column::make(__('In Stock'), 'in_stock')
                ->toggleable(true, 'yes', 'no')
                ->sortable(),

            Column::make(__('Kitchen'), 'kitchen.description', 'kitchen_id')
                ->sortable(),

            Column::make(__('Production date'), 'produced_at_formatted'),
        ];
    }
}
