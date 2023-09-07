<?php

namespace App\Livewire;

use App\Models\Dish;
use Livewire\Component;

class Action extends Component
{
    public string $field = '';

    public Dish $row;

    public array $params = [];

    public function confetti(): void
    {
        $this->js('confetti');
    }

    public function render()
    {
        return view('livewire.action');
    }
}
