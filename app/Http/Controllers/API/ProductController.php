<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController
{
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
