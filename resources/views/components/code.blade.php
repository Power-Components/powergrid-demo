<div class="relative mx-auto mt-12">
    <div class="bg-gray-900 text-white p-4 rounded-md">
        <div class="flex justify-between items-center mb-4">
            <a target="_blank" href="{{ $example->github_url }}" class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md">open in GitHub</a>
            <button class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md" data-clipboard-target="#code">📋 Copy </button>
        </div>
        <div class="overflow-x-auto">
            <pre id="code" class="text-gray-300">
@if (empty(env('TORCHLIGHT_TOKEN')))
<code>{{ $example->source_code }}</code>
@else

<x-torchlight-code language="php" theme="material-theme-darker">{!! $example->source_code !!}</x-torchlight-code> 
@endif
            </pre>
        </div>
    </div>
</div>