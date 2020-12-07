@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Create User</h1>
</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            User Name
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border border-red-400 @enderror">
                        </div>
                        @error('name')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                            Email
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border border-red-400 @enderror">
                        </div>
                        @error('email')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">
                            Phone Number
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('phone_number') border border-red-400 @enderror">
                        </div>
                        @error('phone_number')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <span class="inline-flex rounded-md shadow-sm">
                    <a href="{{ route('users.index') }}"
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
