@extends('layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('main')
    <livewire:is :$component />
    @livewire('wire-elements-modal')
@endsection
