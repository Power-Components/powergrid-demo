<?php

namespace App\Livewire\Examples\ValidationTable;

use App\Models\Icecream;
use App\Rules\EuroCurrencyBetween2and5;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ValidationTable extends PowerGridComponent
{
    public array $flavor;

    public array $price_in_eur;

    public array $in_stock;

    public bool $showErrorBag = true;

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
        return Icecream::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('flavor')
            ->add('in_stock')
            ->add('price_in_eur', fn ($icecream) => Number::currency($icecream->price, in: 'EUR', locale: 'pt_PT'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('🍦 Flavor', 'flavor')
                ->sortable()
                ->editOnClick(hasPermission: true)
                ->searchable(),

            Column::make('Price', 'price_in_eur')
                ->editOnClick(hasPermission: true),

            Column::make('In Stock', 'in_stock')
                ->toggleable(),
        ];
    }

    protected function rules()
    {
        return [
            'flavor.*' => [
                'required',
                'in:chocolate,vanilla,strawberry,coconut,mint,caramel',
                'unique:icecreams,flavor',
            ],

            'in_stock.*' => [
                'required',
                'boolean',
            ],

            'price_in_eur.*' => [
                new EuroCurrencyBetween2and5,
            ],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'flavor.*'       => 'Ice cream flavor',
            'price_in_eur.*' => 'Ice cream price',
        ];
    }

    protected function messages()
    {
        return [
            'flavor.*.in'     => 'Valid flavors: :values',
            'flavor.*.unique' => 'Flavor already listed.',
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        $this->validate();

        if ($field === 'price_in_eur') {
            $field = 'price';

            $value = (new \NumberFormatter('pt-PT', \NumberFormatter::CURRENCY))
                ->parse(preg_replace('/\s+/', "\u{A0}", $value));
        }

        Icecream::query()->find($id)->update([
            $field => e($value),
        ]);
    }

    public function onUpdatedToggleable(string|int $id, string $field, string $value): void
    {
        Icecream::query()->find($id)->update([
            $field => e($value),
        ]);

        $this->skipRender();
    }
}
