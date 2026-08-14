<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader Task</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">

    <!-- Page Content -->
    <main>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>

    <dialog id="image-lightbox" class="m-auto max-w-3xl w-[90vw] rounded-lg bg-transparent p-0 backdrop:bg-black/70">
        <div class="relative">
            <button type="button" data-lightbox-close
                class="absolute top-2 right-2 rounded-full bg-white/90 p-1.5 text-gray-700 shadow hover:bg-white"
                aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
            <img id="image-lightbox-img" src="" alt="" class="max-h-[85vh] w-full rounded-lg object-contain">
        </div>
    </dialog>

</body>
</html>
