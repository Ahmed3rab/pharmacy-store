<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\ProductDiscount;
use App\Models\ProductDiscountItem;

class ProductDiscountItemController extends Controller
{
    public function destroy(ProductDiscount $discount, ProductDiscountItem $item)
    {
        $item->delete();

        return redirect()->route('products-discounts.show', $discount);
    }
}
