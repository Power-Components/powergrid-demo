@props(['selected', 'dishId'])
<div>
    <select wire:change="categoryChanged($event.target.value, {{ $dishId }})">
            @foreach ($options as $id => $name)
                <option
                    value="{{ $id }}"
                    @if ($id == $selected)
                        selected="selected"
                    @endif
                >
                    {{ $name }}
                </option>
            @endforeach

    </select>
</div>