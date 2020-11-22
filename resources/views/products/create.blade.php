@extends('layouts.app', ['pageTitle' => 'Create Product' ])

@section('content')
    <div class="shadow bg-white p-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <div>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                Product Name
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="name" name="name" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="category" class="block text-sm font-medium leading-5 text-gray-700">
                                Category
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <select id="category" name="category_id" class="form-select block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    @foreach(App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="description" class="block text-sm font-medium leading-5 text-gray-700">
                                Product Description
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <textarea id="description" name="description" rows="3" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Write a few sentences about the product.</p>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                Product Thumbnail
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="name" type="file" name="image" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
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
                                Product Price
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                  LYD
                                </span>
                                <input id="price" name="price" class="flex-1 form-input block w-full min-w-0 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="quantity" class="block text-sm font-medium leading-5 text-gray-700">
                                Product Quantity
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                  Box(s)
                                </span>
                                <input id="quantity" name="quantity" class="flex-1 form-input block w-full min-w-0 rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button type="button" class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                          Cancel
                        </button>
                    </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Create
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </div>
@endsection