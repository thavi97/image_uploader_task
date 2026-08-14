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
                'url' => Storage::disk('public')->url($image->path),
                'original_name' => $image->original_name,
            ]);

        return view('pages.index', ['images' => $images]);
    }
}
