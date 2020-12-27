@extends('layouts.app')

@section('header')
<div class="flex justify-start items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Edit Product: {{ $product->name }}</h1>
    @if ($product->trashed())
    <span class="inline-flex items-center mx-2 px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
        Deleted
    </span>
    @endif

</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div>
            <div>
                <div class="flex-shrink-0">
                    <img class="h-72 w-auto" src="{{ $product->imagePath() }}">
                </div>

                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Name
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" name="name" type="text"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border border-red-400 @enderror"
                                value="{{ old('name', $product->name) }}">
                        </div>
                        @error('name')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="position" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Position
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input type="number" id="position" name="position"
                                value="{{ old('position', $product->position) }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('position') border border-red-400 @enderror">
                        </div>
                        @error('position')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="category" class="block text-sm font-medium leading-5 text-gray-700">
                            Category
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <select id="category" name="category"
                                class="form-select border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('category') border border-red-400 @enderror">
                                @foreach(App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="description" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Description
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <textarea id="description" name="description" rows="3"
                                class="form-textarea border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('description') border border-red-400 @enderror">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Write a few sentences about the product.</p>
                        @error('description')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Thumbnail
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" type="file" name="image"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('image')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    {{--<div class="sm:col-span-4">--}}
                    {{--<label for="cover_photo" class="block text-sm leading-5 font-medium text-gray-700">--}}
                    {{--Product Thumbnail--}}
                    {{--</label>--}}
                    {{--<div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">--}}
                    {{--<div class="text-center">--}}
                    {{--<svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">--}}
                    {{--<path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />--}}
                    {{--</svg>--}}
                    {{--<p class="mt-1 text-sm text-gray-600">--}}
                    {{--<button type="button" class="font-medium text-arwad-500 hover:text-arwad-500 focus:outline-none focus:underline transition duration-150 ease-in-out">--}}
                    {{--Upload a file--}}
                    {{--</button>--}}
                    {{--or drag and drop--}}
                    {{--</p>--}}
                    {{--<p class="mt-1 text-xs text-gray-500">--}}
                    {{--PNG, JPG, GIF up to 10MB--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="sm:col-span-4">
                        <label for="price" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Wholesale Price
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm @error('price') border border-red-400 @enderror">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                LYD
                            </span>
                            <input type="number" step="0.25" id="price" name="price"
                                class="flex-1 form-input border border-gray-300 block w-full min-w-0 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                value="{{ old('price', $product->price) }}">
                        </div>
                        @error('price')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="itemPrice" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Item Price
                        </label>
                        <div
                            class="mt-1 flex rounded-md shadow-sm @error('item_price') border border-red-400 @enderror">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                LYD
                            </span>
                            <input type="number" step="0.25" id="itemPrice" name="item_price"
                                class="flex-1 form-input border border-gray-300 block w-full min-w-0 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                value="{{ old('item_price', $product->item_price) }}">
                        </div>
                        @error('item_price')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="sm:col-span-4">
                        <label for="quantity" class="block text-sm font-medium leading-5 text-gray-700">
                            Product Quantity
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm @error('quantity') border border-red-400 @enderror">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                Box(s)
                            </span>
                            <input type="number" step="1" id="quantity" name="quantity"
                                class="flex-1 form-input border border-gray-300 block w-full min-w-0 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                value="{{ old('quantity', $product->quantity) }}">
                        </div>
                        @error('quantity')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <div role="group" aria-labelledby="label-notifications">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-baseline">
                                <div>
                                    <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700"
                                        id="label-notifications">
                                        Publish Status
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <div class="max-w-lg">
                                        <p class="text-sm text-gray-500">Only published products will appear in the
                                            store.</p>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                                <input id="published" name="published" type="checkbox" value="1"
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 @error('published') border border-red-400 @enderror"
                                                    {{ $product->published? 'checked' : null }}>
                                                <label for="published"
                                                    class="ml-3 block text-sm font-medium text-gray-700 @error('published') text-red-400 @enderror">
                                                    Published
                                                </label>
                                            </div>
                                        </div>

                                        @error('published')
                                        <small class="text-red-600 text-sm">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <span class="inline-flex rounded-md shadow-sm">
                    <a href="{{ route('products.index') }}"
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Cancel
                    </a>
                </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Update
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

@if ($product->trashed())
<div class="my-3 flex justify-end">
    <form action="{{ route('products.restore', $product) }}" method="POST">
        @csrf
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-gray-500 hover:text-gray-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Restore This Product
            </button>
        </span>
    </form>
</div>
@else
<div class="my-3 flex justify-end">
    <form action="{{ route('products.destroy', $product) }}" method="POST">
        @csrf
        @method('DELETE')
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-red-500 hover:text-red-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Delete This Product
            </button>
        </span>
    </form>
</div>
@endif

@endsection
