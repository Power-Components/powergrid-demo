@extends('layouts.base')

@section('title')
    Dishes Responsive
@endsection

@section('main')
    <livewire:dishes-table :with-responsive="true"/>
@endsection
