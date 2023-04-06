@extends('layouts.base')

@section('title')
    Multiple
@endsection

@section('main')
    @for($i=1; $i<3;$i++)
        <div class="p-1 font-semibold">TableName: table-{{ $i }}</div>

        <div class="mb-4">
            <livewire:filters-table :category-id="$i" :table-name="'table-'.$i" />
        </div>
    @endfor
@endsection
