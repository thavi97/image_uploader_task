<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the upload form and the two image lists (Azure / local), split by
     * whichever disk each image actually landed on when it was uploaded.
     */
    public function index()
    {
        [$azureImages, $localImages] = Image::latest()->get()
            ->partition(fn (Image $image) => $image->disk === 'azure');

        return view('pages.index', [
            'azureImages' => $this->mapImages($azureImages),
            'localImages' => $this->mapImages($localImages),
        ]);
    }

    /**
     * Turn a collection of Image models into the plain array shape the view needs
     * (id, display url, original filename), building the right kind of URL per disk.
     */
    private function mapImages($images)
    {
        return $images->map(fn (Image $image) => [
            'id' => $image->id,
            'url' => $image->disk === 'azure'
                ? $this->azureUrl($image->path)
                : Storage::disk('public')->url($image->path),
            'original_name' => $image->original_name,
        ]);
    }

    /**
     * Build a readable URL for a blob.
     *
     * The Azure connection string I was given is SAS-token based (no account key),
     * so the SDK can't mint a new signed URL (that requires the key). Instead
     * I parse out the SAS token and endpoint I already have and reuse them directly.
     */
    private function azureUrl(string $path): string
    {
        $parts = [];

        foreach (explode(';', config('filesystems.disks.azure.connection_string')) as $segment) {
            [$key, $value] = explode('=', $segment, 2);
            $parts[$key] = $value;
        }

        $container = config('filesystems.disks.azure.container');
        $encodedPath = implode('/', array_map('rawurlencode', explode('/', $path)));

        return rtrim($parts['BlobEndpoint'], '/')."/{$container}/{$encodedPath}?{$parts['SharedAccessSignature']}";
    }
}
