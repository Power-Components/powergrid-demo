<?php

namespace App\Livewire\Examples\ExportTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ExportTable extends PowerGridComponent
{
    public string $tableName = 'export-table';

    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('export')
                ->striped()
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        return Dish::with('category');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('link', function (Dish $dish) {
                return sprintf(
                    'Click to Search
                    "<a target="_blank"
                    class="underline text-blue-600 hover:text-blue-800 visited:text-purple-600"
                    href="https://www.google.com/search?q=%s">%s</a>"',
                    urlencode(e($dish->name)),
                    e($dish->name)
                );
            })
            ->add('serving_at')
            ->add('price')
            ->add('price_in_eur', fn ($dish) => Number::currency($dish->price, in: 'EUR', locale: 'pt_PT'))
            ->add('chef_name', fn ($dish) => e($dish->chef?->name))
            ->add('in_stock')
            ->add('in_stock_label', fn ($dish) => $dish->in_stock ? 'Yes' : 'No')
            ->add('created_at_formatted', fn ($dish) => Carbon::parse($dish->created_at)->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            //Displayed on the grid, but no in the exported file
            Column::make('Name', 'link', 'name')
                ->visibleInExport(visible: true)
                ->sortable(),

            //Hidden on the grid, but available in the exported file
            Column::make('Name', 'name')
                ->searchable()
                ->hidden()
                ->visibleInExport(visible: true),

            Column::make('Chef', 'chef_name', 'dishes.chef_name')
                ->searchable()
                ->placeholder('Chef placeholder')
                ->sortable(),

            Column::make('Price', 'price_in_eur', 'price')
                ->searchable()
                ->sortable(),

            Column::make('In Stock', 'in_stock_label', 'in_stock'),

            Column::make('Created At', 'created_at_formatted'),
        ];
    }
}
