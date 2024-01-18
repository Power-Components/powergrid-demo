@use('App\Models\Flight')

@extends('layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('source_code')
    <x-code>{{ $source_code }}</x-code>
@endsection

@section('about')
    {!! $about !!}
@endsection

@section('main')
    <livewire:is :$component />
@endsection
