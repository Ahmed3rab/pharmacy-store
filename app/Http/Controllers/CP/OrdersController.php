<?php

namespace App\Http\Controllers\CP;

use App\Models\Order;

class OrdersController
{
    public function index()
    {
        $orders = Order::all();

        return view('orders.index')->with('orders', $orders);
    }

    public function show(Order $order)
    {
        return view('orders.show')->with('order', $order);
    }
}
