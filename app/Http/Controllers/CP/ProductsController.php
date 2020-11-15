<?php

namespace App\Http\Controllers\CP;

use App\Models\Product;

class ProductsController
{
    public function index()
    {
        $products = Product::all();

        return view('products.index')->with('products', $products);
    }
}
