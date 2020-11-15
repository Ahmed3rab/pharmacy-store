<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'thumbnail_path' => $this->thumbnail_path,
            'name' => $this->name,
        ];
    }
}
