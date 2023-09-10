<?php

namespace App\Livewire;

use App\Helpers\PowerGridThemes\TailwindHeaderFixed;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;

final class FixedHeaderTable extends SimpleTable
{
    public array $perPageValues = [0];

    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),

            Footer::make()
                ->showRecordCount(),
        ];
    }

    public function template(): ?string
    {
        return TailwindHeaderFixed::class;
    }
}
