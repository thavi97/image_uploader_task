<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            ],
        ]);

        $path = $request->file('image')->store('images', 'public');

        return back()->with('success', 'You have uploaded an image succesfully!');
    }
}
