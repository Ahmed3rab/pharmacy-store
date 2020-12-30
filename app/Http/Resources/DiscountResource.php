<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid'             => $this->uuid,
            'percentage'       => (float) $this->percentage,
            'starts_at'        => $this->starts_at->toDateTimeString(),
            'ends_at'          => $this->ends_at->toDateTimeString(),
            'featured'         => $this->featured,
            'cover_image_path' => $this->coverImagePath(),
            'products'         => ProductResource::collection($this->whenLoaded('products')),
            'categories'       => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
