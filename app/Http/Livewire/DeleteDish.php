<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use LivewireUI\Modal\ModalComponent;

class DeleteDish extends ModalComponent
{
    public ?int $dishId = null;

    public array $dishIds = [];

    public string $confirmationTitle = '';

    public string $confirmationDescription = '';

    public static function modalMaxWidth(): string
    {
        return 'md';
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
            Dish::query()->find($this->dishId)->delete();
        }

        if ($this->dishIds) {
            Dish::query()->whereIn('id', $this->dishIds)->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }

    public function render()
    {
        return view('livewire.delete-dish');
    }
}
