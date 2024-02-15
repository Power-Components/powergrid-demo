<div>
    @if($row->in_stock == 'Yes')
        <button class="bg-blue-500 text-white font-bold py-2 px-2 rounded" onclick="alert('ordering #{{ $row->id }}')">Order now</button>
    @else
        - out of sock -
    @endif
</div>