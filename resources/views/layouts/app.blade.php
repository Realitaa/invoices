<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-100">
    <x-sidebar>
        @yield('content')
    </x-sidebar>

    @if (session('success'))
        <x-toast :message="session('success')" type="success" />
    @endif

    @if (session('error'))
        <x-toast :message="session('error')" />
    @endif

    @yield('scripts')
</body>
</html>
