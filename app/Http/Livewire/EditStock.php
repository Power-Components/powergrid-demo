<?php

namespace App\Http\Livewire;

use App\Models\Dish;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class EditStock extends ModalComponent
{
    use Actions;

    public ?int $dishId = null;

    #[Rule('required|string')]
    public bool $inStock = false;

    public function mount()
    {
        $this->inStock = Dish::query()->find($this->dishId)->in_stock;
    }

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

    public function confirm(): void
    {
        //        Dish::query()->where('id', $this->dishId)
        //            ->update([
        //                'in_stock' => $this->inStock,
        //            ]);

        $this->notification([
            'title' => 'Dish updated successfully!',
            'icon' => 'success',
            'timeout' => 2000,
        ]);

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
    }

    public function render()
    {
        return view('livewire.edit-stock');
    }
}
