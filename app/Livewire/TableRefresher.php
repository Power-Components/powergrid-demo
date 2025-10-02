<?php

namespace App\Livewire;

use Livewire\Component;

class TableRefresher extends Component
{
    public function refreshTable()
    {
        $this->dispatch('pg:eventRefresh-auto-refresh-table');
    }

    public function render()
    {
        return view('livewire.table-refresher');
    }
}
