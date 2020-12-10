<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'price'    => $this->price,
            'quantity' => $this->quantity,
            'product'  => new ProductResource($this->product),
            'discount' => new DiscountResource($this->discount),
        ];
    }
}