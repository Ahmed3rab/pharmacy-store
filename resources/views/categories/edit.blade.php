@extends('layouts.app')

@section('header')
<div class="flex justify-start items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Edit Category: {{ $category->name }}</h1>
    @if ($category->trashed())
    <span class="inline-flex items-center mx-2 px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
        Deleted
    </span>
    @endif

</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div>
            <div>
                <div class="flex-shrink-0">
                    <img class="h-32 w-32" src="{{ $category->iconPath() }}">
                </div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Category Name
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" value="{{ old('name', $category->name) }}" name="name"
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
                            <input type="number" id="position" name="position"
                                value="{{ old('position', $category->position) }}"
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
                                                    {{ $category->published? 'checked' : null }}>
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
                        Update
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

@if ($category->trashed())
<div class="my-3 flex justify-end">
    <form action="{{ route('categories.restore', $category) }}" method="POST">
        @csrf
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-gray-500 hover:text-gray-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Restore This Category
            </button>
        </span>
    </form>
</div>
@else
<div class="my-3 flex justify-end">
    <form action="{{ route('categories.destroy', $category) }}" method="POST">
        @csrf
        @method('DELETE')
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-red-500 hover:text-red-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Delete This Category
            </button>
        </span>
    </form>
</div>
@endif

@endsection
