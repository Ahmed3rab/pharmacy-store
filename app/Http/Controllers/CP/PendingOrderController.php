<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PendingOrderController extends Controller
{
    public function store(Order $order)
    {
        $order->setAsPending();

        return redirect()->back();
    }
}
