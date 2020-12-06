<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        $categories = Category::orderBy('position')->paginate(20);

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $products = $category->products()->paginate(20);

        return ProductResource::collection($products);
    }
}
