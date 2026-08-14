@if ($images->isEmpty())
    <p class="text-sm text-gray-500">No images uploaded yet.</p>
@else
    <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($images as $image)
            <li class="group relative overflow-hidden rounded-lg border border-gray-200">
                <img src="{{ $image['url'] }}" alt="{{ $image['original_name'] }}" class="h-40 w-full object-cover">

                <form method="POST" action="{{ route('image.destroy', $image['id']) }}" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-full bg-white/90 p-1.5 text-red-600 shadow hover:bg-white"
                        aria-label="Delete image">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.808a2.75 2.75 0 0 0 2.741-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
