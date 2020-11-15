<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $products = $category->products;

        return ProductResource::collection($products);
    }
}
