<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048', // 2MB
                'dimensions:max_width=5000,max_height=5000',
            ],
        ]);

        $file = $request->file('image');

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file)->scaleDown(1024, 1024);
        $encoded = $image->encodeByExtension($file->extension());

        $filename = 'images/'.Str::random(40).'.'.$file->extension();

        if ($request->boolean('offline_mode')) {
            $disk = 'public';
            Storage::disk('public')->put($filename, (string) $encoded);
        } else {
            $disk = 'azure';

            try {
                Storage::disk('azure')->put($filename, (string) $encoded);
            } catch (\Throwable $e) {
                report($e);

                $disk = 'public';
                Storage::disk('public')->put($filename, (string) $encoded);
            }
        }

        Image::create([
            'path' => $filename,
            'disk' => $disk,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $encoded->size(),
            'width' => $image->width(),
            'height' => $image->height(),
        ]);

        return back()->with('success', 'You have uploaded an image succesfully!');
    }

    public function destroy(Image $image)
    {
        try {
            Storage::disk($image->disk)->delete($image->path);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Unable to delete the image right now. Please try again.');
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
