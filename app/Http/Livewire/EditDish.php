<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class EditDish extends ModalComponent
{

    public int $dishId;

    public function render()
    {
        return view('livewire.edit-dish');
    }
}
