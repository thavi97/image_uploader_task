{{-- Root layout used by every page via <x-app-layout>. Page content is injected through $slot. --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader Task</title>

    {{-- Compiles Tailwind, AOS, and app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

    <!-- Page Content -->
    <main>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>

</body>
</html>
