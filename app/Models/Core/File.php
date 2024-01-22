<?php

namespace App\Models\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends BaseModel
{
    use HasFactory;

    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'file_name',
        'file_url',
        'language',
        'mime',
        'original_name',
        'display_name',
        'file_size',
        'thumbnail_url',
        'resized_image_url',
        'cropped_image_url',
    ];
}
