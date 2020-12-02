@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Create User</h1>
</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <div>
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            User Name
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="name" name="name" value="{{ $user->name }}"
                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('name')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                            Email
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="email" id="email" name="email" value="{{ $user->email }}"
                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('email')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-4">
                        <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">
                            Phone Number
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}"
                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('phone_number')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button"
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Cancel
                    </button>
                </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Edit
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
@endsection
