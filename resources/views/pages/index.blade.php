<x-app-layout>
    <section>
        <h1>Image Uploader</h1>

        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        @error('image')
            <p>{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('image.upload') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="image">Choose an image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit">Upload</button>
        </form>
    </section>

    <section>
        <h2>Uploaded Images</h2>

        @if ($images->isEmpty())
            <p>No images uploaded yet.</p>
        @else
            <ul>
                @foreach ($images as $image)
                    <li>
                        <img src="{{ $image['url'] }}" alt="{{ $image['original_name'] }}" width="200">
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-app-layout>
