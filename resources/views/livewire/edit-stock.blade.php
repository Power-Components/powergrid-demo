<div class="p-3">
    <div class="font-semibold font-gray-700 text-lg">Edit Stock</div>

    <div class="py-2">
        DishId: {{ $dishId }}

        <x-toggle wire:model="inStock" label="In Stock" />

        <div class="space-x-2 flex justify-end mt-3">
            <x-button flat label="Cancel" wire:click="cancel"/>
            <x-button primary label="Save" wire:click="confirm"/>
        </div>
    </div>

</div>
