<div>
    @if($row->in_stock == 'Yes')
        <button class="btn btn-primary btn-sm" onclick="alert('ordering #{{ $row->id }}')">Order now</button>
    @else
        - out of sock -
    @endif
</div>
