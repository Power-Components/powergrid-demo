@extends('layouts.base')

@section('title')
    Filters
@endsection

@section('main')
    <div class="space-y-4">

        <livewire:filters-table />

        <div class="font-bold text-lg text-slate-700 ">
            Outside
        </div>

{{--        <livewire:filters-table table-name="outside" :filters-outside="true" />--}}
    </div>
@endsection
