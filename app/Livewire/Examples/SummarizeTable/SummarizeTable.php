<?php

namespace App\Livewire\Examples\SummarizeTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class SummarizeTable extends PowerGridComponent
{
    public string $tableName = 'summarize-table';

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
        return Dish::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('price')
            ->add('created_at')
            ->add('calories', fn ($dish) => $dish->calories . ' kcal')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
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

            Column::make('Calories', 'calories', 'calories')
                ->withAvg('Average', header: true, footer: false)
                ->sortable(),

            Column::make('Price', 'price_in_eur', 'price')
                ->withSum('Sum Price', header: true, footer: false)
                ->withAvg('Avg Price', header: true, footer: false)
                ->withCount('Count Price', header: true, footer: false)
                ->withMin('Min Price', header: false, footer: true)
                ->withMax('Max Price', header: false, footer: true)
                ->sortable(),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }

    public function summarizeFormat(): array
    {
        return [
            'price.{sum,avg,min,max}' => fn ($value) => Number::currency($value, in: 'EUR', locale: 'pt_PT'),
            'price.{count}'           => fn ($value) => Number::format($value, locale: 'br') . ' price(s)',
            'calories.{avg}'          => fn ($value) => Number::format($value, locale: 'br', precision: 2) . ' kcal',
        ];
    }
}
