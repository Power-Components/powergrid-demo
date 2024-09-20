<?php

namespace App\Livewire\Examples\RowTemplatesTable;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Lazy;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

#[Lazy]
class RowTemplatesTable extends PowerGridComponent
{
    public string $tableName = 'row-templates-table';

    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(10)
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
            ->add('name', function ($row) {
                return [
                    'template-name' => [
                        'id'   => $row->id,
                        'name' => $row->name,
                    ],
                ];
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->template()
                ->searchable()
                ->sortable(),
        ];
    }

    public function rowTemplates(): array
    {
        return [
            'template-name' => '<div id="custom-{{ id }}" class="bg-red-100 py-1 rounded px-3">{{ name }}</div>',
        ];
    }
}
