<?php

namespace App\Http\Controllers\CP;

use App\Models\Order;

class OrdersController
{
    public function index()
    {
        $orders = Order::withCount('items')->get();

        return view('orders.index')->with('orders', $orders);
    }

    public function show(Order $order)
    {
        $order->loadCount('items');

        return view('orders.show')->with('order', $order);
    }
}
