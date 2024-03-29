<?php

namespace App\Http\Resources\User;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\Core\ImageResource;
use App\Models\Core\File;
use App\Models\UserLog;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $user = parent::toArray($request);

        if (isset($user[0])) {
            $user = $user[0];
        }

        if (isset($user['image_id'])) {
            $image = File::where('id', $user['image_id'])->first();
            if($image)
                $user['image'] = new ImageResource($image);
        }

        // $userLogs = UserLog::where('user_id', $user['id'])->get();

        $user['user_logs'] = $this->userLogs;

        return $user;
    }
}
