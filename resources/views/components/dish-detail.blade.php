<div class="p-2">
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
