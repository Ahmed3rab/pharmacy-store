<?php

namespace App\Http\Controllers\CP;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductsController
{
    public function index()
    {
        $products = Product::all();

        return view('products.index')->with('products', $products);
    }

    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    public function update(Product $product)
    {
        $product->update([
            'category_id' => request('category_id'),
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'quantity' => request('quantity'),
        ]);

        if (request()->has('image')) {
            // TODO: delete current image before uploading new one.
            $path = request()->file('image')
                ->storeAs(
                    'products',
                    $product->uuid . '-' . time() . '.' . request()->file('image')->extension());

            $product->update([
                'image_path' => $path
            ]);
        }

        return redirect()->route('products.edit', $product);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store()
    {
        $product = Product::create([
            'category_id' => request('category_id'),
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'quantity' => request('quantity'),
        ]);

        if (request()->has('image')) {
            $path = request()->file('image')
                ->storeAs(
                    'products',
                    $product->uuid . '-' . time() . '.' . request()->file('image')->extension());

            $product->update([
                'image_path' => $path
            ]);
        }

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
