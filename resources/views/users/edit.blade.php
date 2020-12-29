@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Edit User</h1>
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
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border border-red-400 @enderror">
                        </div>
                        @error('name')
                        <small class="text-red-600 text-sm">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="sm:col-span-4" x-data="{ tab: '{{ old('type', $type)?: 'app_user' }}' }"
                        class="flex flex-col justify-between space-y-5">
                        <input type="hidden" name="type" x-model="tab">
                        <div class="mb-4">
                            <fieldset>
                                <legend id="radiogroup-label" class="sr-only">
                                    User Type
                                </legend>
                                <ul class="flex space-x-4" role="radiogroup" aria-labelledby="radiogroup-label">
                                    <li @click="tab = 'app_user'" id="radiogroup-option-1" tabindex="-1" role="radio"
                                        aria-checked="false"
                                        class="w-1/2 group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-arwad-500">
                                        <div
                                            class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between  @error('phone_number') border border-red-400 @enderror">
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">
                                                        App User
                                                    </p>
                                                    <div class="text-gray-500">
                                                        <p class="sm:inline">
                                                            Has Acess to mobile app store.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                            :class="{ 'border-arwad-500': tab === 'app_user', 'border-transparent': tab != 'app_user' }"
                                            aria-hidden="true"></div>
                                    </li>

                                    <li @click="tab = 'admin'" id="radiogroup-option-2" tabindex="-1" role="radio"
                                        aria-checked="false"
                                        class="w-1/2 group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-arwad-500">
                                        <d
                                            class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between @error('email') border border-red-400 @enderror">
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">
                                                        Admin
                                                    </p>
                                                    <div class="text-gray-500">
                                                        <p class="sm:inline">
                                                            Has Access to Dashboard
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </d iv>
                                        <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                            :class="{ 'border-arwad-500': tab === 'admin', 'border-transparent': tab != 'admin' }"
                                            aria-hidden="true"></div>
                                    </li>
                                </ul>
                            </fieldset>
                        </div>
                        <template x-if="tab == 'admin'">
                            <div class="sm:col-span-4">
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                                    Email
                                </label>
                                <div class="my-1 rounded-md shadow-sm">
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border border-red-400 @enderror">
                                </div>
                                @error('email')
                                <small class="text-red-600 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </template>
                        <template x-if="tab == 'app_user'">
                            <div class="sm:col-span-4">
                                <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">
                                    Phone Number
                                </label>
                                <div class="my-1 rounded-md shadow-sm">
                                    <input type="text" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number', $user->phone_number) }}"
                                        class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('phone_number') border border-red-400 @enderror">
                                </div>
                                @error('phone_number')
                                <small class="text-red-600 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </template>
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
                        Update
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

@if (! $user->is(auth()->user()))
<div class="my-3 flex justify-end">
    <form action="{{ route('users.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-red-500 hover:text-red-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Permanently Delete This User
            </button>
        </span>
    </form>
</div>
@endif
@endsection
