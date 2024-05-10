<?php

namespace App\Livewire\Examples\BeforesearchHookTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class BeforesearchHookTable extends PowerGridComponent
{
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

    public function datasource(): ?Builder
    {
        return Dish::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('in_stock')
            ->add('in_stock_formatted', fn ($dish) => $dish->in_stock ? 'Available' : 'Unavailable')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable(),

            Column::make('Name', 'name')
                ->searchable(),

            Column::make('Stock', 'in_stock_formatted', 'in_stock')
                ->searchable(),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable(),

            Column::make('Created At', 'created_at_formatted', 'created_at'),

        ];
    }

    public function beforeSearch(?string $field = null, ?string $search = null): ?string
    {
        if ($field === 'in_stock') {
            $search = match (strtolower(trim($search))) {
                'available'   => '1',
                'unavailable' => '0',
                default       => $search,
            };
        }

        if ($field === 'price') {
            $parsedCurrency = (new \NumberFormatter('pt-PT', \NumberFormatter::CURRENCY))
                ->parse(preg_replace('/\s+/', "\u{A0}", $search));

            return $parsedCurrency === false ? floatval($search) : $parsedCurrency;
        }

        return $search;
    }
}
