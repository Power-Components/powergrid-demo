<div class="p-3">
    <div class="font-semibold font-gray-700 text-lg">{{ $confirmationTitle }}</div>

    <div class="py-2">
        @if($dishId)
            DishId: {{ $dishId }}
        @endif
        @if($dishIds)
            DishIds: @json($dishIds)
        @endif
        <div class="font-normal text-gray-600">{{ $confirmationDescription }}</div>
            <div class="space-x-2 flex justify-end mt-3">
                <x-button flat label="Cancel" wire:click="cancel"/>
                <x-button primary label="Save" wire:click="confirm"/>
            </div>
    </div>

</div>
