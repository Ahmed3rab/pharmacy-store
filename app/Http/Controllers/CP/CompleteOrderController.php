<?php

namespace App\Http\Controllers\CP;

use App\Models\Order;

class CompleteOrderController
{
    public function store(Order $order)
    {
        $order->complete();

        return redirect()->back();
    }
}
