@extends('layouts.base')

@section('title')
    Persist
@endsection

@section('main')
    <div class="space-y-4">
        <livewire:filters-table :persist="['columns', 'filters']"/>
    </div>
@endsection
