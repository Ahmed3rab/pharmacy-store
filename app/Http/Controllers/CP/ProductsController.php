<?php

namespace App\Http\Controllers\CP;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController
{
    public function index()
    {
        $products = Product::withTrashed()->latest()->get();

        return view('products.index')->with('products', $products);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'category' => ['required', 'exists:categories,id'],
            'image' => ['required', 'image'],
        ]);

        $product = Product::create([
            'category_id' => request('category'),
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'quantity' => request('quantity'),
        ]);

        if (request()->has('image')) {
            $path = request()->file('image')
                ->storeAs(
                    'products',
                    $product->uuid . '-' . time() . '.' . request()->file('image')->extension(),
                    ['disk' => 'public']
                );

            $product->update([
                'image_path' => $path
            ]);
        }

        return redirect()->route('products.index');
    }

    public function edit($uuid)
    {
        $product = Product::withTrashed()->whereUuid($uuid)->first();

        return view('products.edit')->with('product', $product);
    }

    public function update(Request $request, $uuid)
    {
        $product = Product::withTrashed()->whereUuid($uuid)->first();

        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'category' => ['required', 'exists:categories,id'],
            'image' => ['image'],
        ]);

        $product->update([
            'category_id' => request('category'),
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'quantity' => request('quantity'),
        ]);

        if (request()->has('image')) {
            Storage::disk('public')->delete($product->image_path);
            $path = request()->file('image')
                ->storeAs(
                    'products',
                    $product->uuid . '-' . time() . '.' . request()->file('image')->extension(),
                    ['disk' => 'public']
                );

            $product->update([
                'image_path' => $path,
            ]);
        }

        return redirect()->route('products.edit', $product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    public function restore($uuid)
    {
        $product = Product::withTrashed()->whereUuid($uuid)->first();

        $product->restore();

        return redirect()->route('products.index');
    }
}
