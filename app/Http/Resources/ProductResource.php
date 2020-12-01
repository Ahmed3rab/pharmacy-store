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
            'image_path'  => asset('/storage/' . $this->image_path),
            'name'        => $this->name,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'discount'    => new ProductDiscountItemResource($this->discountItem),
        ];
    }
}
