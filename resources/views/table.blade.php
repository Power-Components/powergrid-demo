@extends('layouts.base')
@section('title')
    {{ $component->title }}
@endsection
@section('main')
    <div class="mt-6 about-example dark:text-slate-200">
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
            <li @click="openTab = 3" :class="{ '-mb-px': openTab === 3 }" class="mr-1" >
                <a href="#" :class="openTab === 3 ? activeClasses : inactiveClasses" class="bg-white dark:bg-slate-900 inline-block py-2 px-4 font-semibold" >
                   Details
                </a>
            </li>
        </ul>
        <div class="w-full py-3">
            <div x-show="openTab === 1">
                @livewire($component->name)
                <div class="mt-2 dark:text-slate-200"><sup><b>Disclaimer: </b>Table data is randomly generated for illustrative purposes only. The information here is not a reflection of the actual market and does not constitute business, financial, or medical advice.</sup></div>
            </div>
            <div x-show="openTab === 2">
                <x-code :example="$component"/>
            </div>
            <div x-show="openTab === 3">
                <p>Here you can find all relevant packages installed on this demo.</p>
                <livewire:installed-packages/>
            </div>
        </div>
    </div>
@endsection
