@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Send Notifications</h1>
</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">
    <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                    <div x-data="{ open : false, selectedUsers: [] }" class="sm:col-span-4">
                        <div class="w-full">
                            <label for="users" class="block text-sm font-medium text-gray-700">Users</label>

                            <div class="flex flex-col items-center relative">
                                <div class="w-full  svelte-1l8159u">
                                    <div class="my-2 p-1 flex border border-gray-200 bg-white rounded svelte-1l8159u">
                                        <div class="flex flex-auto flex-wrap">
                                            <template x-for="(selectedUser, index) in selectedUsers">
                                                <div
                                                    class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-white bg-arwad-500">
                                                    <div class="text-xs font-normal leading-none max-w-full flex-initial"
                                                        x-text="JSON.parse(selectedUser).name"></div>
                                                    <input type="hidden" name="users[]"
                                                        x-bind:value="JSON.parse(selectedUser).uuid">
                                                    <div class="flex flex-auto flex-row-reverse">
                                                        <div @click="selectedUsers.splice(index, 1)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="100%"
                                                                height="100%" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-x cursor-pointer hover:text-arwad-400 rounded-full w-4 h-4 ml-2">
                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <div class="flex-1">
                                                <input x-on:keydown="open = true"
                                                    class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
                                            </div>
                                        </div>
                                        <div
                                            class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">
                                            <button type="button"
                                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-up w-4 h-4">
                                                    <polyline points="18 15 12 9 6 15"></polyline>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <template x-if="open">
                                    <div x-on:click.away="open = false"
                                        class="absolute shadow top-100 bg-white z-40 w-full left-0 mt-10 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                                        <div class="flex flex-col w-full">
                                            @foreach ($users as $user)
                                            <div
                                                class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:text-arwad-500">
                                                <div
                                                    class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-gray-200">
                                                    <div class="w-full items-center flex">
                                                        <div @click="selectedUsers.push('{{ $user }}')"
                                                            class="mx-2 leading-6">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </template>
                            </div>

                            @error('users')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="title" class="block text-sm font-medium leading-5 text-gray-700">
                            Title
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                        @error('title')
                        <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="sm:col-span-4">
                        <label for="body" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2 mb-1">
                            Body
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <textarea id="body" name="body" rows="3"
                                class="form-input shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"></textarea>
                            <p class="mt-2 text-sm text-gray-500">Write the notification content here.</p>
                        </div>
                        @error('body')
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
                        Create
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
@endsection
