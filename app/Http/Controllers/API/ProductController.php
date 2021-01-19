<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController
{
    public function index(Category $category)
    {
        $products = $category->products()->paginate();
        return ProductResource::collection($products);
    }
    public function show(Product $product)
    {
        $product->load('category');
        return new ProductResource($product);
    }
}
