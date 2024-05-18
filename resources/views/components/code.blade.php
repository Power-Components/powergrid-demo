@php
    $hasTorchLight = !empty(env('TORCHLIGHT_TOKEN'));
@endphp
<div class="relative mx-auto text-sm">
    <div class="bg-pg-primary-900 text-white p-4 rounded-md">
        <div class="flex justify-between items-center mb-4">
            <a
                target="_blank"
                href="{{ $example->link() }}"
                class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md"
            >🔎  View on GitHub</a>
            <button
                class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md"
                data-clipboard-target="#code"
            >📋 Copy </button>
        </div>
        <div class="overflow-x-auto">
            <pre
                id="code"
                class="text-gray-300 text-sm"
            >
@if ($hasTorchLight)
<x-torchlight-code language="php" theme="material-theme-darker">{!! $example->sourceCode() !!}</x-torchlight-code>
@else
<code>{{ $example->sourceCode() }}</code>
@endif
            </pre>
        </div>
    </div>
@if ($hasTorchLight)
<div class="mt-2">
    <small>Code highlighting provided by <a href="https://torchlight.dev/" target="_blank">Torchlight.dev</a></small>
</div>
@endif
</div>
