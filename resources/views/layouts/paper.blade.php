<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/paper.css', 'resources/css/app.css'])
    @endif
    <style>@page { size: A4 }</style>
</head>
<body class="A4">
    @yield('content')
</body>
</html>