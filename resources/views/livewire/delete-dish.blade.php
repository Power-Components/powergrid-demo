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
                <button wire:click="cancel"> Cancel </button>
                <button wire:click="confirm"> Save </button>
            </div>
    </div>

</div>
