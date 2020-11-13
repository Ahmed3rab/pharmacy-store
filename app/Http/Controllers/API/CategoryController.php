<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Category;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function show(Category $category)
    {
        $products = $category->products;

        return new ProductCollection($products);
    }
}
