<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PowerGrid - Live Beer and Code</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @livewireStyles
        @powerGridStyles
    </head>
    <body class="bg-indigo-800 font-sans leading-normal tracking-normal m-12">

        <div class="bg-white p-10 rounded">
            <livewire:dishes-table/>
        </div>
        @livewireScripts
        @powerGridScripts

        @livewire('livewire-ui-modal')
        @livewireUIScripts
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    </body>
</html>
