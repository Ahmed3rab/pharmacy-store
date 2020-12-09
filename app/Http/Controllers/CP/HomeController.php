<?php

namespace App\Http\Controllers\CP;

use App\Filters\OrderFilter;
use App\Http\Controllers\Controller;
use App\Models\Order;

class HomeController extends Controller
{
    public function show(OrderFilter $orderFilter)
    {
        $pendingOrdersCount = Order::whereNull('completed_at')->filter($orderFilter)->count();
        $completedOrdersCount = Order::whereNotNull('completed_at')->filter($orderFilter)->count();
        $ordersCount = Order::filter($orderFilter)->count();

        return view('cp', [
            'pendingOrdersCount'   => $pendingOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'ordersCount'          => $ordersCount,
        ]);
    }
}
