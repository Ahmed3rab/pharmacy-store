<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid'      => $this->uuid,
            'icon_path' => $this->iconPath(),
            'position'  => (int) $this->position,
            'name'      => $this->name,
            'discount'  => new DiscountResource($this->activeDiscount),
            'products'  => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
