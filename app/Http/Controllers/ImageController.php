<?php

namespace App\Http\Controllers;

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

        $filename = 'images/'.Str::random(40).'.'.$file->extension();

        Storage::disk('public')->put($filename, (string) $image->encodeByExtension($file->extension()));

        return back()->with('success', 'You have uploaded an image succesfully!');
    }
}
