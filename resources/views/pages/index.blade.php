<x-app-layout>
    <section>
        <h1>Image Uploader</h1>

        <form method="POST" action="{{ route('image.upload') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="image">Choose an image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit">Upload</button>
        </form>
    </section>
</x-app-layout>
