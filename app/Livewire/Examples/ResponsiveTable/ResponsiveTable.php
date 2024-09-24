<?php

namespace App\Livewire\Examples\ResponsiveTable;

use App\Livewire\Examples\DemoDishTable\DemoDishTable;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;

final class ResponsiveTable extends DemoDishTable
{
    public string $tableName = 'responsive-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),

            PowerGrid::responsive()
                ->fixedColumns('dishes.name', 'actions'),
        ];
    }
}
