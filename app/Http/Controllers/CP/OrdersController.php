<?php

namespace App\Http\Controllers\CP;

use App\Filters\OrderFilter;
use App\Models\Order;

class OrdersController
{
    public function index(OrderFilter $filter)
    {
        $orders = Order::filter($filter)->withCount('items')->get();

        return view('orders.index')->with('orders', $orders);
    }

    public function show(Order $order)
    {
        $order->loadCount('items');

        return view('orders.show')->with('order', $order);
    }
}
