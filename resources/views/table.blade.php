@extends('layouts.base')
@section('title')
    {{ $component->title() }}
@endsection
@section('main')
    <div class="mt-3 text-sm about-example leading-6">
        {!! $component->about() !!}
    </div>

    <div x-data="{ openTab: 1 }" class="py-3 tracking-wider text-sm">
        <div role="tablist" class="tabs tabs-border">
            <a role="tab" @click="openTab = 1" :class="openTab === 1 ? 'tab tab-active' : 'tab'">Example</a>
            <a role="tab" @click="openTab = 2" :class="openTab === 2 ? 'tab tab-active' : 'tab'">Source Code</a>
        </div>
        <div class="w-full py-3">
            <div x-cloak x-show="openTab === 1">
                {!! $component->render() !!}
                <div class="mt-2 ">
                    <sup><b>Disclaimer: </b>Table data is randomly generated for illustrative purposes only. The information here is not a reflection of the actual market and does not constitute business, financial, or medical advice.</sup>
                </div>
            </div>
            <div x-cloak x-show="openTab === 2">
                <x-code :example="$component" />
            </div>
        </div>
    </div>
@endsection
