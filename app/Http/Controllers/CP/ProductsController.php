<?php

namespace App\Http\Controllers\CP;

use App\Actions\Products\CreateProduct;
use App\Actions\Products\UpdateProduct;
use App\Models\Order;
use App\Models\Product;

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

    public function store()
    {
        (new CreateProduct)->create();

        flash(__('messages.product.create'));

        return redirect()->route('products.index');
    }

    public function edit($uuid)
    {
        $product = Product::withTrashed()->whereUuid($uuid)->first();

        return view('products.edit')->with('product', $product);
    }

    public function update($uuid)
    {
        $product = (new UpdateProduct)->update($uuid);

        flash(__('messages.product.update'));

        return redirect()->route('products.edit', $product);
    }

    public function destroy(Product $product)
    {
        if (Order::pending()->hasProduct($product)->count()) {
            flash(__('messages.product.delete'));
            return redirect()->back();
        }

        $product->delete();
        flash(__('messages.product.delete'));

        return redirect()->route('products.index');
    }

    public function restore($uuid)
    {
        $product = Product::withTrashed()->whereUuid($uuid)->first();

        $product->restore();

        flash(__('messages.product.restore'));

        return redirect()->route('products.index');
    }
}
