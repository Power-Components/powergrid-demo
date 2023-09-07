<?php

namespace App\Livewire;

use App\Models\Dish;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use WireUi\Traits\Actions;

final class WireElementsModalTable extends PowerGridComponent
{
    use Actions;

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

    public function datasource()
    {
        return Dish::with('category');
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('chef_name')
            ->addColumn('price')
            ->addColumn('in_stock')
            ->addColumn('in_stock_label', function ($entry) {
                return $entry->in_stock ? 'sim' : 'não';
            })
            ->addColumn('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y');
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

            Column::make('Chef', 'chef_name')
                ->searchable()
                ->sortable(),

            Column::make('Price', 'price')
                ->sortable(),

            Column::make('In Stock', 'in_stock_label')
                ->toggleable()
                ->field('in_stock'),

            Column::make('Created At', 'created_at_formatted'),

            Column::action('Action'),
        ];
    }

    public function onUpdatedToggleable(string $id, string $field, string $value): void
    {
        $this->notification([
            'title' => 'onUpdatedToggleable',
            'description' => "Id: {$id}, Field: {$field}, Value: {$value}",
            'icon' => 'success',
            'timeout' => 4000,
        ]);

        //        Dish::query()->where('id', $id)->update([
        //            $field => $value,
        //        ]);
    }

    public function actions($dish): array
    {
        return [
            Button::add('edit-stock')
                ->bladeComponent('button.circle', [
                    'primary' => true,
                    'icon' => 'pencil',
                ])
                ->openModal('edit-stock', [
                    'dishId' => $dish->id,
                ]),

            Button::add('delete-stock')
                ->bladeComponent('button.circle', [
                    'negative' => true,
                    'icon' => 'trash',
                ])
                ->openModal('delete-dish', [
                    'dishId' => $dish->id,
                ]),
        ];
    }
}
