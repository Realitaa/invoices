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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "var(--color-green-500)",
                    }
                }).showToast();
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "var(--color-red-500)",
                    },
                }).showToast();
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>
