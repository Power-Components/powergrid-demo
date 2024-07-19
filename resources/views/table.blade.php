@extends('layouts.base')
@section('title')
    {{ $component->title() }}
@endsection
@section('main')
    <div class="mt-6 mb-5 about-example dark:text-neutral-200 leading-10">
        {!! $component->about() !!}
    </div>
    <!-- based on: https://tailwindflex.com/@mr-robot/tab-navigation-with-alpine-js -->
    <div x-data="{
        openTab: 1,
        activeClasses: 'border-l border-t border-r dark:border-pg-primary-700 font-bold rounded-t',
        inactiveClasses: 'font-light'
    }" class="py-3 tracking-wider text-sm">
        <ul class="flex items-center border-b dark:border-neutral-600">
            <li @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" class="-mb-px mr-1">
                <a href="#" :class="openTab === 1 ? activeClasses : inactiveClasses"
                    class="bg-white dark:bg-pg-primary-900 dark:text-pg-primary-200 inline-block py-2 px-4 font-semibold"> Example </a>
            </li>
            <li @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" class="mr-1">
                <a href="#" :class="openTab === 2 ? activeClasses : inactiveClasses"
                    class="bg-white dark:bg-pg-primary-900 dark:text-pg-primary-200 inline-block py-2 px-4 font-semibold">
                    Source Code
                </a>
            </li>
        </ul>
        <div class="w-full py-3">
            <div x-cloak x-show="openTab === 1">
                {!! $component->render() !!}
                <div class="mt-2 dark:text-slate-200"><sup><b>Disclaimer: </b>Table data is randomly generated for
                        illustrative purposes only. The information here is not a reflection of the actual market and does
                        not constitute business, financial, or medical advice.</sup></div>
            </div>
            <div x-cloak x-show="openTab === 2">
                <x-code :example="$component" />
            </div>
        </div>
    </div>
@endsection
