<div x-show="sideBarOpen" x-cloak class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-slate-600 bg-opacity-75" aria-hidden="true"></div>

    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-slate-900 focus:outline-none">

        <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button x-on:click="sideBarOpen = false" type="button"
                class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Close sidebar</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 flex items-center px-4">
                <img class="h-8 w-auto"
                    src="https://raw.githubusercontent.com/Power-Components/livewire-powergrid/main/art/logo.svg"
                    alt="Workflow">
            </div>
            <nav aria-label="Sidebar" class="mt-5">
                <div class="px-2 space-y-1">
                    @foreach ($menu as $item)
                        <a wire:navigate href="{{ data_get($item, 'route') }}"
                            class="text-slate-600 hover:bg-slate-50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-600 group flex items-center px-2 py-2 text-base font-medium rounded-md">
                            {{ data_get($item, 'label') }}
                        </a>
                    @endforeach
                </div>
            </nav>
        </div>

    </div>

    <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Force sidebar to shrink to fit close icon -->
    </div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex-1 flex flex-col min-h-0 border-r border-slate-200 dark:border-gray-600 bg-slate-100 dark:bg-slate-900">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    <img class="h-8 w-auto"
                        src="https://raw.githubusercontent.com/Power-Components/livewire-powergrid/main/art/logomark.svg"
                        alt="Workflow">
                </div>
                <nav class="mt-5 flex-1" aria-label="Sidebar">
                    <div class="px-2 space-y-1 text-sm">
                        @foreach ($menu as $item)
                            <a wire:navigate @class([
                                'bg-slate-200 border-l border-slate-400 !text-slate-800 dark:text-slate-200 transition duration-300' => request()->routeIs(
                                    data_get($item, 'name')),
                                'text-slate-600 font-semibold hover:bg-slate-300 dark:text-slate-300 hover:text-slate-900 dark:hover:bg-slate-600 group flex items-center px-2 py-2 text-base font-medium rounded-md',
                            ]) href="{{ data_get($item, 'route') }}">
                                {{ data_get($item, 'label') }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
