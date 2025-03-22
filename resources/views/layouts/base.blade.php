<!DOCTYPE html>
<html>
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

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-theme class="antialiased h-screen">
    <div
        class="h-full flex"
        x-data="{ sideBarOpen: false }"
    >
        <x-layout.menu />

        <div class="flex flex-col min-w-0 flex-1 overflow-hidden">
            <div class="lg:hidden">
                <div
                    class="flex items-center justify-between bg-base-300 px-4 py-1.5">
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
                <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none xl:order-last">

                    <!-- Start main area-->
                    <div class="py-6 px-4 sm:px-6 lg:px-8 bg-base-100 space-y-2">

                        <div class="dropdown flex justify-end">
                            <div tabindex="0" role="button" class="btn">
                                Theme
                                <svg
                                    width="12px"
                                    height="12px"
                                    class="inline-block h-2 w-2 fill-current opacity-60"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 2048 2048">
                                    <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                                </svg>
                            </div>
                            <ul tabindex="0" class="dropdown-content bg-base-300 rounded-box z-1 w-52 p-2 shadow-2xl">
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Light"
                                        value="light" />
                                </li>
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Dark"
                                        value="dark" />
                                </li>
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Retro"
                                        value="retro" />
                                </li>
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Cyberpunk"
                                        value="cyberpunk" />
                                </li>
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Valentine"
                                        value="valentine" />
                                </li>
                                <li>
                                    <input
                                        type="radio"
                                        name="theme-dropdown"
                                        class="theme-controller w-full btn btn-sm btn-block btn-ghost justify-start"
                                        aria-label="Aqua"
                                        value="aqua" />
                                </li>
                            </ul>
                        </div>

                        @yield('source_code')

                        <div
                            class="h-full border-dashed rounded-lg">
                            <div class="font-bold text-lg ">@yield('title')</div>

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
