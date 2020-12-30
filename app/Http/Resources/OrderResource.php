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
            'uuid'                       => $this->uuid,
            'reference_number'           => $this->reference_number,
            'order_items_count'          => $this->items()->count(),
            'order_items_quantity_count' => $this->items()->sum('quantity'),
            'created_at'                 => $this->created_at,
            'is_complete'                => $this->isComplete(),
            'status'                     => $this->status,
            'notes'                      => $this->notes,
            'total'                      => $this->items->sum('total'),
            'items'                      => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
