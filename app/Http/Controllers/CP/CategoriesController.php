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
            'name'      => ['required', 'string', 'min:3'],
            'position'  => ['nullable', 'numeric'],
            'icon'      => ['required', 'image'],
            'published' => ['nullable', 'boolean'],
        ]);

        $category = Category::create([
            'name'      => request('name'),
            'position'  => request('position'),
            'published' => request('published') ? true : false,
        ]);

        if (request()->has('icon')) {
            $path = request()->file('icon')
                ->storeAs(
                    'categories',
                    $category->uuid . '-' . time() . '.' . request()->file('icon')->extension(),
                    ['disk' => 'public']
                );

            $category->update([
                'icon_path' => $path,
            ]);
        }

        flash(__('messages.category.create'));

        return redirect()->route('categories.index');
    }

    public function edit($uuid)
    {
        $category = Category::withTrashed()->whereuuid($uuid)->first();

        return view('categories.edit')->with('category', $category);
    }

    public function update(Request $request, $uuid)
    {
        $category = Category::withTrashed()->whereuuid($uuid)->first();

        $request->validate([
            'name'      => ['required', 'string', 'min:3'],
            'position'  => ['nullable', 'numeric'],
            'icon'      => ['image'],
            'published' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name'      => request('name'),
            'position'  => request('position'),
            'published' => request('published') ? true : false,
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
                'icon_path' => $path,
            ]);
        }

        flash(__('messages.category.update'));

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        flash(__('messages.category.delete'));

        return redirect()->route('categories.index');
    }

    public function restore($uuid)
    {
        $category = Category::withTrashed()->whereUuid($uuid)->first();

        $category->restore();

        flash(__('messages.category.restore'));

        return redirect()->route('categories.index');
    }
}
