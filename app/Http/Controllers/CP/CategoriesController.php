<?php

namespace App\Http\Controllers\CP;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController
{
    public function index()
    {
        $categories = Category::withTrashed()->latest()->get();

        return view('categories.index')->with('categories', $categories);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'icon' => ['required', 'image'],
        ]);

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

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'icon' => ['image'],
        ]);

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

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
