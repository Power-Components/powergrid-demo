<div class="p-2 bg-white border border-neutral-200 dark:border-gray-800 dark:bg-neutral-900 dark:text-gray-300">
    <div>This is coming from a different view!</div>
    <div>Id {{ $id }}</div>
    <div>Name {{ $row->name }}</div>
    <div>Options @json($options)</div>

    <div class="flex justify-end">
        <button wire:click.prevent="toggleDetail('{{ $id }}')" class="p-1 text-xs bg-red-600 text-white rounded-lg py-2 px-2">Close</button>
    </div>
</div>
