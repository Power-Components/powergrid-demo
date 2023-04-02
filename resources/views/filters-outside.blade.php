@extends('layouts.base')

@section('title')
    Filters outside
@endsection

@section('main')
    <div class="space-y-4">
        <livewire:filters-table table-name="outside" :filters-outside="true" />
    </div>
@endsection
