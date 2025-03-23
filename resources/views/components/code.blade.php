<div class="relative mx-auto text-sm">
    <div class="bg-neutral-900 text-white p-4 rounded-md">
        <div class="flex justify-between items-center mb-4">
            <a
                target="_blank"
                href="{{ $example->link() }}"
                class="code bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-1 rounded-md"
            >🔎  View on GitHub</a>
        </div>
        <div class="overflow-x-auto">
            {!! $example->sourceCode() !!}
        </div>
    </div>
</div>
