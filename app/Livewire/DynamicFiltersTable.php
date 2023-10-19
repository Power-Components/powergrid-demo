<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use WireUi\Traits\Actions;

final class DynamicFiltersTable extends PowerGridComponent
{
    use Actions;

    public int $categoryId = 0;

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    protected $queryString = ['filters'];

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->withoutLoading()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
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

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
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

            ->addColumn('diet', function (Dish $dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })
            ->addColumn('sales_price')
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

    public function filters(): array
    {
        return [
            Filter::dynamic('category_name', 'category_id')
                ->component('select')
                ->attributes([
                    'class' => '!min-w-[170px]',
                    'async-data' => route('category.index'),
                    'option-label' => 'name',
                    'multiselect' => false,
                    'option-value' => 'id',
                    'placeholder' => 'Test',
                    'wire:model.live' => 'filters.select.category_id',
                ]),
        ];
    }
}
