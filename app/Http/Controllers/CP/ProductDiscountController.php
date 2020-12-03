<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Rules\UniqueProduct;

class ProductDiscountController extends Controller
{
    public function index()
    {
        $discounts = ProductDiscount::all();

        return view('products-discounts.index')->with('discounts', $discounts);
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('products-discounts.create')
            ->with([
                'categories' => $categories,
                'products'   => $products,
            ]);
    }

    public function store()
    {
        request()->validate([
            'title'      => 'required|string',
            'percentage' => 'required|numeric|between:1,99',
            'starts_at'  => 'required|date',
            'ends_at'    => 'required|date',
            'category'   => ['nullable', 'required_without:products', 'exists:categories,uuid', new UniqueProduct],
            'products'   => 'nullable|required_if:category,|array',
            'products.*' => ['nullable', 'exists:products,uuid', new UniqueProduct],
        ]);

        $discount = ProductDiscount::create([
            'title'      => request('title'),
            'percentage' => request('percentage'),
            'starts_at'  => request('starts_at'),
            'ends_at'    => request('ends_at'),
        ]);

        if ($category = Category::whereUuid(request('category'))->first()) {
            $category->products->each(function ($product) use ($discount) {
                $discount->items()->create([
                    'product_id' => $product->id,
                    'price_after' => $discount->getSalePriceOfProduct($product),
                ]);
            });
        }

        if ($products = request('products')) {
            Product::whereIn('uuid', $products)->get()->each(function ($product) use ($discount) {
                $discount->items()->create([
                    'product_id' => $product->id,
                    'price_after' => $discount->getSalePriceOfProduct($product),
                ]);
            });
        }

        return redirect()->route('products.discounts.index');
    }

    public function show(ProductDiscount $discount)
    {
        $discount->load('items');

        return view('products-discounts.show')->with('discount', $discount);
    }

    public function destroy(ProductDiscount $discount)
    {
        $discount->items()->delete();
        $discount->delete();

        return redirect()->route('products.discounts.index');
    }
}
