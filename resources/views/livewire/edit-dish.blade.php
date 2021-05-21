<div>
    <div class="p-4">
        <strong>Modal working!..</strong>
        <div class="py-4">
            Dish ID: {{ $dishId }}
        </div>

        <div class="text-right">
            <button class="p-2 border-2 rounded-md bg-indigo-600 text-white" wire:click="$emit('closeModal')">Close</button>
        </div>
    </div>
</div>
