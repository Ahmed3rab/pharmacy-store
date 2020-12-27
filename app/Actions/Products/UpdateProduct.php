<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class UpdateProduct
{
    public function update($productUuid)
    {
        $product = Product::withTrashed()->whereUuid($productUuid)->first();

        request()->validate([
            'name'        => ['required', 'string', 'min:3'],
            'position'    => ['nullable', 'numeric'],
            'description' => ['required', 'string', 'min:3'],
            'price'       => ['required', 'numeric'],
            'quantity'    => ['required', 'numeric'],
            'category'    => ['required', 'exists:categories,id'],
            'image'       => ['image'],
            'published'   => ['nullable', 'boolean'],
        ]);

        $product->update([
            'category_id' => request('category'),
            'name'        => request('name'),
            'position'    => request('position'),
            'description' => request('description'),
            'price'       => request('price'),
            'quantity'    => request('quantity'),
            'published'   => request('published') ? true : false,
        ]);

        if (request()->has('image')) {
            Storage::disk('public')->delete($product->image_path);
            $product->setImage(request()->file('image'));
        }

        return $product;
    }
}
