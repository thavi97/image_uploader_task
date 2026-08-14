{{-- Main page: upload form + the two storage lists (Azure / local), populated by HomeController::index() --}}
<x-app-layout>
    <section class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Image Uploader</h1>

        {{-- Flash messages set by ImageController --}}
        @if (session('success'))
            <p class="mb-4 rounded-md bg-green-50 px-4 py-2 text-sm text-green-700">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="mb-4 rounded-md bg-red-50 px-4 py-2 text-sm text-red-700">{{ session('error') }}</p>
        @endif

        {{-- Validation errors from ImageController::store() (size, dimensions, mime type, etc.) --}}
        @error('image')
            <p class="mb-4 rounded-md bg-red-50 px-4 py-2 text-sm text-red-700">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('image.upload') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Choose an image</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            {{--
                Skips the Azure attempt entirely and uploads straight to local storage if offline mode is checked.
            --}}
            <label class="flex items-center gap-2 text-sm text-gray-600" title="Skip Azure and upload straight to local storage">
                <input type="checkbox" name="offline_mode" value="1" data-persist="offline_mode" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                Offline mode
            </label>

            <button type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 self-start">
                Upload
            </button>
        </form>
    </section>

    {{-- Images that actually landed in the Azure Blob container --}}
    <section class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Azure Blob Storage</h2>
        @include('components.image-list', ['images' => $azureImages])
    </section>

    {{-- Images that fell back to (or were forced to via Offline mode) the local public disk --}}
    <section class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Local Storage</h2>
        @include('components.image-list', ['images' => $localImages])
    </section>
</x-app-layout>
