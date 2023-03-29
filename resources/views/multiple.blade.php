@extends('layouts.base')

@section('title')
    Multiple
@endsection

@section('main')
    @for($i=1; $i<5;$i++)
        <livewire:filters-table :category-id="$i" :table-name="'table-'.$i" />
    @endfor
@endsection
