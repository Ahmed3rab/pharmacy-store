@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Create Category</h1>
</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Category Name
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" name="name" value="{{ old('name') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border border-red-400 @enderror">
                        </div>
                        @error('name')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="position" class="block text-sm font-medium leading-5 text-gray-700">
                            Category Position
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input type="number" id="position" name="position" value="{{ old('position') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('position') border border-red-400 @enderror">
                        </div>
                        @error('position')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Category Icon
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" type="file" name="icon"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('icon') border border-red-400 @enderror">
                        </div>
                        @error('icon')
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
                                        <p class="text-sm text-gray-500">Only published categories will appear in the
                                            store</p>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                                <input id="published" name="published" type="checkbox" value="1"
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 @error('published') border border-red-400 @enderror"
                                                    checked>
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
                    <a href="{{ route('categories.index') }}"
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Cancel
                    </a>
                </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Create
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
@endsection
