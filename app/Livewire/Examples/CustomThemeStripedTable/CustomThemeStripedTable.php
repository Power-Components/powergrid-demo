<?php

namespace App\Livewire\Examples\CustomThemeStripedTable;

use App\Helpers\PowerGridThemes\TailwindStriped;
use App\Models\Dish;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class CustomThemeStripedTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::query()
            ->join('categories as newCategories', function ($categories) {
                $categories->on('dishes.category_id', '=', 'newCategories.id');
            })
            ->select('dishes.*', 'newCategories.name as category_name')
            ->toBase();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('in_stock', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->bodyAttribute('!text-wrap')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable()
                ->sortable(),

            Column::make('In Stock', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    #[On('edit')]
    public function edit(int $dishId): void
    {
        $this->js('alert(' . $dishId . ')');
    }

    public function template(): ?string
    {
        return TailwindStriped::class;
    }
}
