<div x-data="{ expanded: false }">
    <div class="mt-3 mb-3 p-2 bg-gray-200 border border-gray-400">

        <button @click="expanded = ! expanded">
            <span
                class="text-xs"
                x-show="!expanded"
            >▶ </span>
            <span
                class="text-xs"
                x-show="expanded"
            >▼ </span>
            View Code
        </button>
    </div>

    <!-- Based on: https://tailwindflex.com/@alok/code-block-with-copy-button -->
        <div
            x-show="expanded"
            x-collapse
            class="relative mx-auto mt-12">
            <div class="bg-gray-900 text-white p-4 rounded-md">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-400">Code:</span>
                    <button class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md" data-clipboard-target="#code" > Copy </button> </div>
                <div class="overflow-x-auto">
                    <pre id="code" class="text-gray-300" >

                        @if (empty(env('TORCHLIGHT_TOKEN')))
                            <code>{{ $slot }}</code>
                        @else
                        <x-torchlight-code x-show="expanded" x-collapse language="php" theme="material-theme-darker" >{!!  html_entity_decode($slot) !!}</x-torchlight-code> 
                        @endif
                    </pre>
                </div>
            </div>
        </div>
    
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    new ClipboardJS('.code');
</script>
