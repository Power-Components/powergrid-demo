<?php

namespace App\Livewire\Examples\CustomFieldBarcodeTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class CustomFieldBarcodeTable extends PowerGridComponent
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
        return Dish::query();
    }

    public function fields(): PowerGridFields
    {
        $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorPNG;

        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('in_stock', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at))
            ->add('barcode', function (Dish $dish) use ($barcodeGenerator) {
                return sprintf(
                    '<img src="data:image/png;base64,%s">',
                    base64_encode($barcodeGenerator->getBarcode($dish->id, $barcodeGenerator::TYPE_CODE_128))
                );
            });
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

            Column::make('Barcode', 'barcode'),

            Column::make('In Stock', 'in_stock')
                ->searchable(),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }
}
