<div class="p-2 bg-white border border-neutral-200 dark:border-gray-800 dark:bg-neutral-900 dark:text-gray-300">
    <div class="font-bold">Dish Details</div>
    <div>Id {{ $id }}</div>
    <div>
        @if($row->calories >= 300)
        🔥🔥🔥 This dish is caloric.
        @else
        🪶 This dish is light.
        @endif
    </div>
</div>
