<?php

namespace App\Livewire\Examples\FiltersInlineTable;

use App\Enums\Diet;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;

use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

class FiltersInlineTable extends PowerGridComponent
{
    public string $tableName = 'filters-inline-table';

    use WithExport;

    public int $categoryId = 0;

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }

    public function setUp(): array
    {
        $this->showCheckBox('id');

        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->withoutLoading()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Dish::with(['category', 'kitchen'])
            ->when(
                $this->categoryId,
                fn ($builder) => $builder->whereHas(
                    'category',
                    fn ($builder) => $builder->where('category_id', $this->categoryId)
                )
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
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('storage_room')
            ->add('calories_formatted', fn ($dish) => $dish->calories . ' kcal')
            ->add('chef_name', fn ($dish) => e($dish->chef?->name))
            ->add('category_id', fn ($dish) => intval($dish->category_id))
            ->add('category_name', fn ($dish) => e($dish->category->name))
            ->add('price')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('diet', fn ($dish) => Diet::from($dish->diet)->labels())
            ->add('price_BRL', fn ($dish) => Number::currency($dish->price, in: 'BRL', locale: 'pt-BR'))
            ->add('in_stock')
            ->add('in_stock_label', fn ($entry) => $entry->in_stock ? 'In Stock' : 'Out of Stock')
            ->add('produced_at_formatted', fn ($dish) => Carbon::parse($dish->produced_at))
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->timezone('America/Sao_Paulo')->format('d/m/Y'));
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
                ->title('Calories')
                ->field('calories_formatted', 'calories')
                ->sortable(),

            Column::make('Category', 'category_name', 'category_id'),

            Column::make('Chef', 'chef_name')
                ->searchable(),

            Column::add()
                ->title('Price')
                ->field('price_BRL', 'price'),

            Column::make('Diet', 'diet', 'dishes.diet'),

            Column::make('In Stock', 'in_stock_label', 'in_stock'),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Dish Name'),

            Filter::boolean('in_stock', 'in_stock')
                ->label('In Stock', 'Out of Stock'),

            Filter::boolean('calories')
                ->label('🔥 Caloric', '🪶 Light')
                ->builder(function (Builder $query, string $value) {
                    $q = match ($value) {
                        default => ['operator' => '>=', 'calories' => 0],
                        'true'  => ['operator' => '>=', 'calories' => 300],
                        'false' => ['operator' => '<',  'calories' => 300],
                    };

                    return $query->where('calories', $q['operator'], $q['calories']);
                }),

            Filter::enumSelect('diet', 'dishes.diet')
                ->dataSource(Diet::cases())
                ->optionLabel('dishes.diet'),

            Filter::select('category_name', 'category_id')
                ->dataSource(Category::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::number('price_BRL', 'price')
                ->thousands('.')
                ->decimal(',')
                ->placeholder('lowest', 'highest'),

            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'America/Sao_Paulo',
                ]),
        ];
    }
}
