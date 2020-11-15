<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;

class CategoriesController
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index')->with('categories', $categories);
    }
}
