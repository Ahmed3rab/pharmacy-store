<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Rules\UniqueProduct;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->get();

        return view('discounts.index')->with('discounts', $discounts);
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('discounts.create')
            ->with([
                'categories' => $categories,
                'products'   => $products,
            ]);
    }

    public function store()
    {
        request()->validate([
            'title'        => 'required|string',
            'percentage'   => 'required|numeric|between:1,99',
            'starts_at'    => 'required|date',
            'ends_at'      => 'required|date|after:today',
            'categories'   => ['nullable', 'required_without:products', 'array'],
            'categories.*' => ['nullable', 'required_without:products', 'exists:categories,uuid', new UniqueProduct],
            'products'     => 'nullable|required_without:categories|array',
            'products.*'   => ['nullable', 'exists:products,uuid', new UniqueProduct],
        ]);

        $discount = Discount::create([
            'title'      => request('title'),
            'percentage' => request('percentage'),
            'starts_at'  => request('starts_at'),
            'ends_at'    => request('ends_at'),
        ]);

        if ($categories = request('categories')) {
            $discount->categories()->attach(Category::whereIn('uuid', $categories)->get());
        }

        if ($products = request('products')) {
            $discount->products()->attach(Product::whereIn('uuid', $products)->get());
        }

        flash(__('messages.discount.create'));

        return redirect()->route('discounts.index');
    }

    public function show(Discount $discount)
    {
        $discount->load(['categories', 'products']);

        return view('discounts.show')->with('discount', $discount);
    }

    public function edit(Discount $discount)
    {
        $categories = Category::all();
        $products = Product::all();
        $selectedProducts = $discount->products;
        $selectedCategories = $discount->categories;

        return view('discounts.edit')
            ->with([
                'categories'         => $categories,
                'products'           => $products,
                'discount'           => $discount,
                'selectedProducts'   => $selectedProducts,
                'selectedCategories' => $selectedCategories,
            ]);;
    }

    public function update(Discount $discount)
    {
        request()->validate([
            'title'        => 'required|string',
            'percentage'   => 'required|numeric|between:1,99',
            'starts_at'    => 'required|date',
            'ends_at'      => 'required|date|after:today',
            'categories'   => ['nullable', 'required_without:products', 'array'],
            'categories.*' => ['nullable', 'required_without:products', 'exists:categories,uuid', new UniqueProduct($discount)],
            'products'     => 'nullable|required_without:categories|array',
            'products.*'   => ['nullable', 'exists:products,uuid', new UniqueProduct($discount)],
        ]);

        $discount->update([
            'title'      => request('title'),
            'percentage' => request('percentage'),
            'starts_at'  => request('starts_at'),
            'ends_at'    => request('ends_at'),
        ]);

        $discount->categories()->detach();
        $discount->products()->detach();

        if ($categories = request('categories')) {
            $discount->categories()->sync(Category::whereIn('uuid', $categories)->get());
        }

        if ($products = request('products')) {
            $discount->products()->sync(Product::whereIn('uuid', $products)->get());
        }

        flash(__('messages.discount.update'));

        return redirect()->route('discounts.index');
    }

    public function destroy(Discount $discount)
    {
        $discount->categories()->detach();
        $discount->products()->detach();

        $discount->delete();

        flash(__('messages.discount.delete'));

        return redirect()->route('discounts.index');
    }
}
