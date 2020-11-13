<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function __construct($token, $user = null)
    {
        $this->token = $token;
        $this->user = $user;
    }

    public function toArray($request)
    {
        return [
            'data' => [
                'access_token' => $this->token,
                'user'         => new UserResource($this->user),
            ],
        ];
    }
}
