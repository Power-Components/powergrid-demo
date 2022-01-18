<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PowerGrid - Live Beer and Code</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    @livewireStyles

    @livewireScripts

    @powerGridStyles

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="dark:bg-gray-400 bg-gray-200 font-sans leading-normal tracking-normal mx-8 mt-10">

<div class="container" style="margin-top: 26px;">
    <livewire:dishes-table/>
</div>

@powerGridScripts

</body>
</html>
