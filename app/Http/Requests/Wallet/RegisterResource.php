<?php

namespace App\Http\Resources\Wallet;

use App\Http\Resources\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray($request)
    {
        $this->makeVisible('registration_token');

        return parent::toArray($request);
    }
}
