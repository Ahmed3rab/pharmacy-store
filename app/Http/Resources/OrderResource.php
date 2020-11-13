<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'reference_number' => $this->reference_number,
            'order_items_count' => $this->items->count(),
            'order_items_quantity_count' => $this->items->sum('quantity'),
            'created_at' => $this->created_at,
        ];
    }
}
