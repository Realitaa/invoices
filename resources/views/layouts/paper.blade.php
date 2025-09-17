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
<body>
    <div class="A4 break-after-page">
        @yield('page1')
    </div>
    <div class="A4 break-after-page">
        @yield('page2')
    </div>
    <div class="A4 break-after-page">
        @yield('page3')
    </div>
</body>
</html>
