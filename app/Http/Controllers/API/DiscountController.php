<?php

namespace App\Http\Controllers\API;

use App\Filters\DiscountFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index(DiscountFilter $filter)
    {
        $discounts = Discount::filter($filter)->paginate();

        return DiscountResource::collection($discounts);
    }

    public function show(Discount $discount)
    {
        $discount->load(['products', 'categories.products'])->paginate();

        return new DiscountResource($discount);
    }
}
