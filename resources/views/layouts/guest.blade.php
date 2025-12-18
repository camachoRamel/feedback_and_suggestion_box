<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 flex flex-col">
    <main class="flex-1 flex items-center justify-center px-4 py-8 sm:py-10">
        <div class="w-full max-w-xl">
            @yield('content')
        </div>
    </main>

    <x-footer />
</body>
</html>
