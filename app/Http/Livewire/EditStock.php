<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use LivewireUI\Modal\ModalComponent;

class EditStock extends ModalComponent
{
    public ?int $dishId = null;

    public ?array $dishIds = [];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm()
    {
        if ($this->dishId) {
           // Dish::query()->find($this->dishId)->delete();
        }

        if ($this->dishIds) {
           // Dish::query()->whereIn('id', $this->dishIds)->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }

    public function render()
    {
        return view('livewire.edit-stock');
    }
}
