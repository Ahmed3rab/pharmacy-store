<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'uuid'        => $this->uuid,
            'image_path'  => $this->imagePath(),
            'name'        => $this->name,
            'position'    => $this->position,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'item_price'  => (float) $this->item_price,
            'price'       => (float) $this->price,
            'price_after' => (float) $this->price_after,
            'discount'    => new DiscountResource($this->activeDiscount),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
