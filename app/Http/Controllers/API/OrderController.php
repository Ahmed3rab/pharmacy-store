<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Models\Product;

class OrderController
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(20);

        return OrderResource::collection($orders);
    }

    public function store()
    {
        $order = auth()->user()->orders()->create([
            'reference_number' => 'ABCD-1234',
        ]);

        foreach(request('cart_items') as $item)
        {
            $product = Product::where('uuid', $item['product_uuid'])->firstOrFail();

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([], 201);
    }
}
