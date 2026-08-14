<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $images = collect(Storage::disk('public')->files('images'))
            ->map(fn (string $path) => Storage::disk('public')->url($path));

        return view('pages.index', ['images' => $images]);
    }
}
