<?php

namespace App\Livewire\Examples\ResponsiveTable;

use App\Livewire\Examples\DishTable\DishTable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Responsive;

final class ResponsiveTable extends DishTable
{
    public function setUp(): array
    {
        return [
            Header::make()
                ->showToggleColumns()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage()
                ->showRecordCount(),

            Responsive::make()
                ->fixedColumns('dishes.name', Responsive::ACTIONS_COLUMN_NAME),
        ];
    }
}
