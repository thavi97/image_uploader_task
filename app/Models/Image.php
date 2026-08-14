<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'disk',
        'original_name',
        'mime_type',
        'size',
        'width',
        'height',
    ];
}
