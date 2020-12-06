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
        request()->validate([
            'cart_items'                => 'required|array',
            'cart_items.*.product_uuid' => 'required|exists:products,uuid',
            'cart_items.*.quantity'     => 'required|numeric',
            'notes'                     => 'nullable',
        ]);

        $order = auth()->user()->orders()->create([
            'reference_number' => 'ABCD-1234',
            'notes'            => request('notes'),
        ]);

        foreach (request('cart_items') as $item) {
            $product = Product::where('uuid', $item['product_uuid'])->firstOrFail();

            $order->items()->create([
                'product_id'               => $product->id,
                'product_discount_item_id' => $product->activeDiscountItem ? $product->activeDiscountItem->id : null,
                'quantity'                 => $item['quantity'],
                'price'                    => $product->activeDiscountItem ? $product->activeDiscountItem->price_after : $product->price,
            ]);
        }

        return response()->json([], 201);
    }
}
