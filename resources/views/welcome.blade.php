<!DOCTYPE html>
<html x-data="{ darkMode: localStorage.getItem('dark')} "
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{ 'dark': darkMode }"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PowerGrid - Live Beer and Code</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @if(powerGridTheme() === 'tailwind')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
              crossorigin="anonymous">
    @endif
    @livewireStyles
    @powerGridStyles

</head>
<body class="dark:bg-gray-400 bg-gray-200 font-sans leading-normal tracking-normal mx-8 mt-10">

@livewireScripts

@if(powerGridTheme() === 'bootstrap')

    <div class="container" style="margin-top: 26px;">
        <livewire:dishes-table/>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
            integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
            crossorigin="anonymous"></script>

@else
    <div
        class="dark:bg-gray-900 bg-white p-4 rounded-md shadow-lg">
        <div class="flex justify-end align-middle items-baseline items-center space-x-2 px-4 py-4">
            <div>
                    <span class="ml-2" id="annual-billing-label" @click="darkMode = !darkMode; $refs.switch.focus()"
                          style="margin-top: 0 !important;position: absolute;margin-left: -46px;">
                      <span class="text-sm font-medium uppercase"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !(darkMode) }"
                            x-text="darkMode ? 'Dark': 'Light'"></span>
                    </span>
                <button type="button"
                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200"
                        role="switch" aria-checked="false" x-ref="switch"
                        :class="{ 'bg-gray-300': !(darkMode), 'bg-gray-400': darkMode }"
                        aria-labelledby="annual-billing-label"
                        :aria-checked="darkMode" @click="darkMode = !darkMode">
                            <span aria-hidden="true"
                                  class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0"
                                  :class="{ 'translate-x-0': !(darkMode), 'translate-x-5': darkMode }">
                            </span>
                </button>
            </div>
        </div>

        <livewire:dishes-table/>
    </div>

@endif

@powerGridScripts
@livewire('livewire-ui-modal')

</body>
</html>
