<?php

namespace App\Actions\Products;

use App\Models\Product;

class CreateProduct
{
    public function create()
    {
        request()->validate([
            'name'        => ['required', 'string', 'min:3'],
            'position'    => ['nullable', 'numeric'],
            'description' => ['required', 'string', 'min:3'],
            'price'       => ['required', 'numeric'],
            'quantity'    => ['required', 'numeric'],
            'category'    => ['required', 'exists:categories,id'],
            'image'       => ['required', 'image'],
            'published'   => ['nullable', 'boolean'],
        ]);

        $product = Product::create([
            'category_id' => request('category'),
            'name'        => request('name'),
            'position'    => request('position'),
            'description' => request('description'),
            'price'       => request('price'),
            'quantity'    => request('quantity'),
            'published'   => request('published') ? true : false,
        ]);

        $product->setImage(request()->file('image'));
    }
}
