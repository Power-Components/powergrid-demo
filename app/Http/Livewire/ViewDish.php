<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class ViewDish extends ModalComponent
{
    public int $dishId;

    public function render()
    {
        return view('livewire.view-dish');
    }

    public function close()
    {
        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }
}
