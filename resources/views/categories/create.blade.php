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
                                <input id="name" name="name" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                Category Icon
                            </label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="name" type="file" name="icon" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
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