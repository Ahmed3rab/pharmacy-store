<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Models\Order;
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
        request()->validate([
            'cart_items'                => 'required|array',
            'cart_items.*.product_uuid' => 'required|exists:products,uuid',
            'cart_items.*.quantity'     => 'required|numeric',
            'notes'                     => 'nullable',
        ]);

        $order = auth()->user()->orders()->create([
            'notes' => request('notes'),
        ]);

        foreach (request('cart_items') as $item) {
            $product = Product::where('uuid', $item['product_uuid'])->firstOrFail();

            $order->items()->create([
                'product_id'  => $product->id,
                'discount_id' => $product->activeDiscount ? $product->activeDiscount->id : null,
                'quantity'    => $item['quantity'],
                'price'       => $product->activeDiscount ? $product->price_after : $product->price,
            ]);
        }

        return response()->json([], 201);
    }

    public function show(Order $order)
    {
        $order->load('items');

        return new OrderResource($order);
    }
}
