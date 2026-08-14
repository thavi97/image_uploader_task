<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

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
