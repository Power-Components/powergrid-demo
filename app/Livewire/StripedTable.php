<?php

namespace App\Livewire;

use App\Helpers\PowerGridThemes\TailwindStriped;

final class StripedTable extends SimpleTable
{
    public function template(): ?string
    {
        return TailwindStriped::class;
    }
}
