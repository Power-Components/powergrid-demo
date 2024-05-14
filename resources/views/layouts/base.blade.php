<!DOCTYPE html>
<html
    x-data="{ darkMode: localStorage.getItem('darkMode') == 'true' ?? true }"
    x-init="() => {
        toggleDark = () => {
            darkMode = !darkMode
            localStorage.setItem('darkMode', darkMode)
        }
    }"
    x-bind:class="{ 'dark': darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="@luanfreitasdev and @dansysanalyst">
    <meta name="keywords" content="laravel, livewire, datatable,  data table, grid, php, alpine, tall stack, tailwind, bootstrap, table example, laravel package, sorting tables, table ui, table html">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>PowerGrid Demo - @yield('title')</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    >
    <wireui:scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased h-screen">
    <div
        class="h-full flex"
        x-data="{ sideBarOpen: false }"
    >
        <x-layout.menu />

        <div class="flex flex-col min-w-0 flex-1 overflow-hidden">
            <div class="lg:hidden">
                <div
                    class="flex items-center justify-between bg-neutral-50 dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700 px-4 py-1.5">
                    <div>
                        <img
                            class="h-8 w-auto"
                            src="https://raw.githubusercontent.com/Power-Components/livewire-powergrid/main/art/logomark.svg"
                            alt="Workflow"
                        >
                    </div>
                    <div>
                        <button
                            x-on:click="sideBarOpen = true"
                            type="button"
                            class="-mr-3 h-12 w-12 inline-flex items-center justify-center rounded-md text-neutral-500 hover:text-neutral-900"
                        >
                            <span class="sr-only">Open sidebar</span>
                            <!-- Heroicon name: outline/menu -->
                            <svg
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-1 relative z-0 flex overflow-hidden">
                <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none xl:order-last dark:bg-neutral-900">

                    <!-- Start main area-->
                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        @persist('toggle-button')
                        <div class="gap-2 flex mb-2">
                            <span
                                class="items-center"
                                @click="$refs.switch.focus()"
                            >
                                <span
                                    class="text-sm font-medium uppercase text-neutral-800 dark:text-gray-300"
                                    x-text="darkMode ? 'Dark': 'Light'"
                                ></span>
                            </span>
                            <button
                                type="button"
                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200"
                                role="switch"
                                aria-checked="false"
                                x-ref="switch"
                                :class="{ 'bg-neutral-300': !(darkMode), 'bg-neutral-400': darkMode }"
                                aria-labelledby="annual-billing-label"
                                :aria-checked="darkMode"
                                @click="toggleDark"
                            >
                                <span
                                    aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0"
                                    :class="{ 'translate-x-0': !(darkMode), 'translate-x-5': darkMode }"
                                >
                                </span>
                            </button>
                        </div>
                        @endpersist
                        @yield('source_code')

                        <div
                            class="h-full dark:border-neutral-800 border-dashed rounded-lg py-6">
                            <div class="font-bold text-lg text-neutral-700 dark:text-neutral-300">@yield('title')</div>

                            <div>
                                @yield('about')
                            </div>

                            @yield('main')
                        </div>
                    </div>
                    <!-- End main area -->
                </main>
            </div>
        </div>
    </div>
    @livewireScriptConfig
</body>

</html>
