@extends('layouts.base')
@section('title')
    {{ $component->title }}
@endsection
@section('main')
    <div class="about-example">
        {!! $component->about !!}
    </div>
    <!-- based on: https://tailwindflex.com/@mr-robot/tab-navigation-with-alpine-js -->
    <div
        x-data="{
            openTab: 1,
            activeClasses: 'border-l border-t border-r dark:border-slate-700 rounded-t text-yellow-600',
            inactiveClasses: 'text-yellow-500 hover:text-yellow-400'
        }"
        class="py-3">
        <ul class="flex border-b dark:border-slate-600">
            <li @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" class="-mb-px mr-1" >
                <a href="#" :class="openTab === 1 ? activeClasses : inactiveClasses" class="bg-white dark:bg-slate-900 inline-block py-2 px-4 font-semibold" > Example </a>
            </li>
            <li @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" class="mr-1" >
                <a href="#" :class="openTab === 2 ? activeClasses : inactiveClasses" class="bg-white dark:bg-slate-900 inline-block py-2 px-4 font-semibold" >
                    Source Code
                </a>
            </li>
        </ul>
        <div class="w-full py-3">
            <div x-show="openTab === 1">
                @livewire($component->name)
                <div class="mt-2"><sup><b>Disclaimer: </b>Table data is randomly generated for illustrative purposes only. The information here is not a reflection of the actual market and does not constitute business, financial, or medical advice.</sup></div>
            </div>
            <div x-show="openTab === 2">
                <x-code :example="$component"/>
            </div>
        </div>
    </div>
@endsection
