<?php

namespace App\Helper;

use App\Models\Core\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class FileUploader
{
    public const EXTENSIONS = [
        'image' => [
            'jpeg',
            'png',
            'jpg',
            'gif',
            'svg',
            'JPG',
            'JPEG',
            'PNG',
        ],
        'video' => [
            'mp4',
            'avi',
            'mov',
            'ogg',
            'qt',
        ],
        'audio' => [
            'mpga',
            'mp3',
            'wav',
            'audio/mpeg',
            'audio/mpeg4-generic',
            'audio/mp3',
            'audio/mpga',
            'mov',
        ],
        'file' => [
            'srt',
            'txt',
            'pdf',
        ],
    ];

    public static function storeToLocal($file, string $folder, $lang = null, $displayName = null, $storageDisk = 'local', $fileContent = null): object
    {
        ini_set('memory_limit', '512M');
        Log::debug("storeToLocal 1");
        // get file size
        $fileSize = $file->getSize();

        Log::debug("storeToLocal 2" . $fileSize);

        $fileExtension = $file->getClientOriginalExtension();

        // original name
        $fileOriginalName = $file->getClientOriginalName();

        // filename to store
        $fileNewName = Str::random(60) . '.' . $fileExtension;

        Log::debug("storeToLocal 3 " . $storageDisk. " - ". $fileNewName );

        $url = "";
        if ($storageDisk == 'digitalocean') {
            try {
                $path = Storage::disk('digitalocean')->put($folder . '/' . $fileNewName, $fileContent, 'public');
                $path = \Illuminate\Support\Facades\Storage::disk('digitalocean')->url($folder . '/' . $fileNewName);
            } catch (\Exception $e) {
                // Log or handle the exception
                //dd($e->getMessage());
                Log::debug($e->getMessage());
            }
        } else {
            $path = $file->storeAs($folder, $fileNewName, 'public');
        }
        if ($path == 0) {
            $path = 'product/' . $fileNewName;
        }

        Log::debug("storeToLocal path " . $path );

        $resourceArray = [
            'file_name' => $fileNewName,
            'file_url' => $path,
            'mime' => $fileExtension,
            'file_size' => $fileSize,
            'original_name' => $fileOriginalName,
        ];


        Log::debug("return" );

        return File::create($resourceArray);
    }
}
