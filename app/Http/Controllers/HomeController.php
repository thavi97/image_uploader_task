<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get()
            ->map(fn (Image $image) => [
                'id' => $image->id,
                'url' => $image->disk === 'azure'
                    ? $this->azureUrl($image->path)
                    : Storage::disk('public')->url($image->path),
                'original_name' => $image->original_name,
            ]);

        return view('pages.index', ['images' => $images]);
    }

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
