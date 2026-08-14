<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::post('/upload', [ImageController::class, 'store'])
    ->name('image.upload');

Route::delete('/images/{image}', [ImageController::class, 'destroy'])
    ->name('image.destroy');
