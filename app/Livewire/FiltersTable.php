<?php

namespace App\Livewire;

use App\Enums\Diet;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use NumberFormatter;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

class FiltersTable extends PowerGridComponent
{
    use WithExport;

    public int $categoryId = 0;

    public bool $deferLoading = true;

    public string $loadingComponent = 'components.my-custom-loading';

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }

    public function setUp(): array
    {
        $this->showCheckBox('id');

        return [
            Exportable::make('export')
                ->striped()
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            Header::make()
                ->showToggleColumns()
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
            'chef' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        $fmt = new NumberFormatter('ca_ES', NumberFormatter::CURRENCY);

        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('storage_room')
            ->add('chef_name', function (Dish $dish) {
                return $dish->chef->name ?? '-';
            })
            ->add('serving_at')
            ->add('calories')
            ->add('calories', function (Dish $dish) {
                return $dish->calories.' kcal';
            })
            ->add('category_id', function ($dish) {
                return $dish->category_id;
            })
            ->add('category_name', function ($dish) {
                return $dish->category->name;
            })
            ->add('price')
            ->add('price_EUR', function (Dish $dish) use ($fmt) {
                return $fmt->formatCurrency($dish->price, 'EUR');
            })
            ->add('diet', function (Dish $dish) {
                return \App\Enums\Diet::from($dish->diet)->labels();
            })
            ->add('price_BRL', function (Dish $dish) {
                return 'R$ '.number_format($dish->price, 2, ',', '.'); //R$ 1.000,00
            })
            ->add('sales_price')
            ->add('sales_price_BRL', function (Dish $dish) {
                $sales_price = $dish->price + ($dish->price * 0.15);

                return 'R$ '.number_format($sales_price, 2, ',', '.'); //R$ 1.000,00
            })
            ->add('in_stock')
            ->add('in_stock_label', function ($entry) {
                return $entry->in_stock ? 'Yes' : 'No';
            })
            ->add('produced_at_formatted', function (Dish $dish) {
                return Carbon::parse($dish->produced_at)
                    ->format('d/m/Y');
            })
            ->add('created_at_formatted', function (Dish $dish) {
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

            Column::make('Category', 'category_name'),

            Column::make('Chef', 'chef_name')
                ->searchable(),

            Column::add()
                ->title(__('Price'))
                ->field('price_BRL'),

            Column::make('Sale Price', 'sales_price_BRL'),

            Column::make('Calories', 'calories')
                ->sortable(),

            Column::make('Diet', 'diet', 'dishes.diet'),

            Column::make('In Stock', 'in_stock_label', 'in_stock'),
            Column::make('Produced At', 'produced_at_formatted', 'produced_at')
                ->sortable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function beforeSearch(?string $field = null, ?string $search = null): ?string
    {
        if ($field === 'in_stock') {
            return str(strtolower($search))
                ->replace('no', '0')
                ->replace('yes', '1')
                ->toString();
        }

        return $search;
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),

            Filter::boolean('in_stock', 'in_stock')
                ->label('In stock', 'Out of stock')
                ->builder(function (Builder $query, string $value) {
                    return $query->where('in_stock', $value === 'true' ? 1 : 0);
                }),

            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(Diet::cases())
                ->optionLabel('dishes.diet'),

            Filter::select('category_name', 'category_id')
                ->dataSource(Category::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('chef_name', 'chef_id')
                ->depends(['category_id'])
                ->dataSource(fn ($depends) => Chef::query()
                    ->when(isset($depends['category_id']),
                        fn (Builder $query) => $query->whereRelation('categories',
                            fn (Builder $builder) => $builder->where('id', $depends['category_id'])
                        )
                    )
                    ->get()
                )
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::number('price_BRL', 'price')
                ->thousands('.')
                ->decimal(','),

            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'America/Sao_Paulo',
                ]),

            Filter::dynamic('category_name', 'category_id')
                ->component('select')
                ->attributes([
                    'async-data' => route('category.index'),
                    'option-label' => 'name',
                    'multiselect' => false,
                    'option-value' => 'id',
                    'wire:model.blur' => 'filters.select.category_id',
                ]),
        ];
    }
}
