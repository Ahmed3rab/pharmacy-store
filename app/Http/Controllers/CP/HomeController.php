<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Order;

class HomeController extends Controller
{
    public function show()
    {
        $pendingOrdersCount = Order::whereNull('completed_at')->count();
        $completedOrdersCount = Order::whereNotNull('completed_at')->count();
        $ordersCount = Order::count();

        return view('cp', [
            'pendingOrdersCount'   => $pendingOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'ordersCount'          => $ordersCount,
        ]);
    }
}
