<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoriesController
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index')->with('categories', $categories);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store()
    {
        $category = Category::create([
            'name' => request('name'),
        ]);

        if (request()->has('icon')) {
            $path = request()->file('icon')
                ->storeAs(
                    'categories',
                    $category->uuid . '-' . time() . '.' . request()->file('icon')->extension(),
                    ['disk' => 'public']
                );

            $category->update([
                'icon_path' => $path
            ]);
        }

        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('categories.edit')->with('category', $category);
    }

    public function update(Category $category)
    {
        $category->update([
            'name' => request('name'),
        ]);

        if (request()->has('icon')) {
            Storage::disk('public')->delete($category->icon_path);
            $path = request()->file('icon')
                ->storeAs(
                    'categories',
                    $category->uuid . '-' . time() . '.' . request()->file('icon')->extension(),
                    ['disk' => 'public']
                );

            $category->update([
                'icon_path' => $path
            ]);
        }

        return redirect()->route('categories.index');
    }
}
