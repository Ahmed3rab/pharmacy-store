<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountItem;

class DiscountItemController extends Controller
{
    public function destroy(Discount $discount, DiscountItem $item)
    {
        $item->delete();

        return redirect()->route('discounts.show', $discount);
    }
}
