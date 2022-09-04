<div>
    <p>
        Dish has {{ $row->calories }} ({{ $options['message'] }})
    </p>

    <div class="flex justify-begin">
        <button wire:click.prevent="toggleDetail('{{ $id }}')" class="mt-2 p-1 text-xs bg-red-600 text-white rounded-lg">Close</button>
    </div>
</div>
