<?php

namespace App\Http\Livewire;

use App\Enums\Diet;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use NumberFormatter;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class FiltersTable extends PowerGridComponent
{
    use ActionButton;

    public bool $filtersOutside = false;

    public int $categoryId = 0;

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        if ($this->filtersOutside) {
            config(['livewire-powergrid.filter' => 'outside']);
        }

        return Dish::query()
            ->when(
                $this->categoryId,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->categoryId)
                )
                    ->with(['category', 'kitchen'])
            );
    }

    public function relationSearch(): array
    {
        return [
            'category' => [
                'name',
            ],
        ];
    }

    public function addColumns(): PowerGridEloquent
    {
        $fmt = new NumberFormatter('ca_ES', NumberFormatter::CURRENCY);

        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('storage_room')
            ->addColumn('chef_name')
            ->addColumn('serving_at')
            ->addColumn('calories')
            ->addColumn('calories', function (Dish $dish) {
                return $dish->calories.' kcal';
            })
            ->addColumn('category_id', function ($dish) {
                return $dish->category_id;
            })
            ->addColumn('category_name', function ($dish) {
                return $dish->category->name;
            })
            ->addColumn('price')
            ->addColumn('price_EUR', function (Dish $dish) use ($fmt) {
                return $fmt->formatCurrency($dish->price, 'EUR');
            })
            ->addColumn('diet', function (Dish $dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })
            ->addColumn('price_BRL', function (Dish $dish) {
                return 'R$ '.number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })
            ->addColumn('sales_price')
            ->addColumn('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function ($entry) {
                return $entry->in_stock ? 'Yes' : 'No';
            })
            ->addColumn('produced_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->produced_at)
                    ->format('d/m/Y');
            })
            ->addColumn('created_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->created_at)
                    ->timezone('America/Sao_Paulo')
                    ->format('d/m/Y H:i');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Dish', 'name')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Serving at')
                ->field('serving_at')
                ->sortable(),

            Column::make('Chef', 'chef_name')
                ->searchable()
                ->sortable(),

            Column::make('Category', 'category_name'),

            Column::add()
                ->title(__('Price'))
                ->field('price_BRL'),

            Column::make('Sale Price', 'sales_price_BRL'),

            Column::make('Calories', 'calories')
                ->sortable(),

            Column::make('Diet', 'diet', 'dishes.diet'),

            Column::make('In Stock', 'in_stock_label', 'in_stock'),
            Column::make('Produced At', 'produced_at_formatted')
                ->sortable(),

            Column::make('Created At', 'created_at_formatted')
                ->sortable(),
        ];
    }

    public function actions(): array
    {
        return [
            Button::make('edit-stock', 'Edit')
                ->class('text-center')
                ->openModal('edit-stock', ['dishId' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('text-center')
                ->emit('deletedEvent', ['dishId' => 'id'])
                ->method('delete'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')
                ->placeholder('Test')
                ->operators(['contains']),

            Filter::boolean('in_stock', 'in_stock')
                ->label('In stock', 'Out of stock')
                ->builder(function (Builder $query, string $value) {
                    return $query->where('in_stock', $value === 'true' ? 1 : 0);
                }),

            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(Diet::cases())
                ->optionLabel('dishes.diet'),

            Filter::multiSelectAsync('category_name', 'category_id')
                ->url(route('category.index'))
                ->method('POST')
                ->parameters([0 => 'Luan'])
                ->optionValue('id')
                ->optionLabel('name'),

            Filter::number('price_BRL', 'price'),

            Filter::datepicker('produced_at_formatted', 'produced_at'),

            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'America/Sao_Paulo',
                ]),
        ];
    }
}