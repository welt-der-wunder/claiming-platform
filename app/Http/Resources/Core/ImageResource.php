<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        $url = $this->file_url;
        if (strpos($url, "http") === 0) {

        }else{
            $url = asset('storage/' . $this->file_url);
        }
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'file_url' => $url,
            'mime' => $this->mime,
            'language' => $this->language,
            'display_name' => $this->display_name,
            'original_name' => $this->original_name,
        ];
    }
}
