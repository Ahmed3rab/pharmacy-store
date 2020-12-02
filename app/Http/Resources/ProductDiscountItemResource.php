<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDiscountItemResource extends JsonResource
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
            'price_after' => $this->price_after,
            'percentage'  => $this->productDiscount->percentage,
            'starts_at'   => $this->productDiscount->starts_at,
            'ends_at'     => $this->productDiscount->ends_at,
        ];
    }
}
