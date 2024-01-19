<?php

namespace App\Livewire;

use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Lazy;

class LazyLoadTable extends SimpleTable
{
    public string $tableName = 'simpleTable';

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showPerPage(100)
                ->showRecordCount(),

            Lazy::make()
                ->rowsPerChildren(25),
        ];
    }
}
