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

                    <div class="sm:col-span-4" x-data="{ tab: '{{ old('scope')?: 'all' }}' }"
                        class="flex flex-col justify-between space-y-5">
                        <input type="hidden" name="scope" x-model="tab">
                        <div class="">
                            <fieldset>
                                <legend id="radiogroup-label" class="sr-only">
                                    Server size
                                </legend>
                                <ul class="flex space-x-4" role="radiogroup" aria-labelledby="radiogroup-label">
                                    <li @click="tab = 'all'" id="radiogroup-option-1" tabindex="-1" role="radio"
                                        aria-checked="false"
                                        class="group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-arwad-500">
                                        <div
                                            class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between">
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">
                                                        All Users
                                                    </p>
                                                    <div class="text-gray-500">
                                                        <p class="sm:inline">
                                                            Notification will be sent to all registered users.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                            :class="{ 'border-arwad-500': tab === 'all', 'border-transparent': tab != 'all' }"
                                            aria-hidden="true"></div>
                                    </li>

                                    <li @click="tab = 'users'" id="radiogroup-option-2" tabindex="-1" role="radio"
                                        aria-checked="false"
                                        class="group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-arwad-500">
                                        <d
                                            class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between @error('users') border border-red-400 @enderror">
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">
                                                        Specific Users
                                                    </p>
                                                    <div class="text-gray-500">
                                                        <p class="sm:inline">
                                                            Select Specific Users to send the the notification.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </d iv>
                                        <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                            :class="{ 'border-arwad-500': tab === 'users', 'border-transparent': tab != 'users' }"
                                            aria-hidden="true"></div>
                                    </li>
                                </ul>
                            </fieldset>

                        </div>
                        <template x-if="tab == 'users'">
                            <div class="sm:col-span-4">
                                <div class="space-y-4">
                                    <div x-data="component({{ old('users')? \App\Models\User::whereIn('uuid', old('users'))->get() : '[]' }})"
                                        class="sm:col-span-4">
                                        <div class="w-full">
                                            <label for="users"
                                                class="block text-sm font-medium text-gray-700">Users</label>

                                            <div class="flex flex-col items-center relative">
                                                <div class="w-full  svelte-1l8159u">
                                                    <div
                                                        class="my-2 p-1 flex border border-gray-300 @error('users') border border-red-400 @enderror bg-white rounded svelte-1l8159u">
                                                        <div class="flex flex-auto flex-wrap">
                                                            <template x-for="(selectedUser, index) in selectedUsers">
                                                                <div
                                                                    class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-white bg-arwad-500">
                                                                    <div class="text-xs font-normal leading-none max-w-full flex-initial"
                                                                        x-text="selectedUser.name"></div>
                                                                    <input type="hidden" name="users[]"
                                                                        x-bind:value="selectedUser.uuid">
                                                                    <div class="flex flex-auto flex-row-reverse">
                                                                        <div @click="selectedUsers.splice(index, 1)">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="100%" height="100%" fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-x cursor-pointer hover:text-arwad-400 rounded-full w-4 h-4 ml-2">
                                                                                <line x1="18" y1="6" x2="6" y2="18">
                                                                                </line>
                                                                                <line x1="6" y1="6" x2="18" y2="18">
                                                                                </line>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </template>

                                                            <div class="flex-1">
                                                                <input x-on:keydown="open = true"
                                                                    x-on:input.debounce.750="searchForUser($event)"
                                                                    class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">
                                                            <button type="button"
                                                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="100%"
                                                                    height="100%" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-chevron-up w-4 h-4">
                                                                    <polyline points="18 15 12 9 6 15"></polyline>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <template x-if="open">
                                                    <div x-on:click.away="open = false"
                                                        class="absolute shadow top-12 bg-white z-40 w-full left-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                                                        <div class="flex flex-col w-full">
                                                            <template x-for="(user, index) in users">
                                                                <div
                                                                    class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:text-arwad-500">
                                                                    <div
                                                                        class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-gray-200">
                                                                        <div class="w-full items-center flex">
                                                                            <div @click="addUser(user)"
                                                                                class="mx-2 leading-6"
                                                                                x-text="user.name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <script>
                                                function component(intialUsers) {
                                                  return {
                                                    open: false,
                                                    allUsers:  {!! json_encode($users->toArray()) !!},
                                                    users:  {!! json_encode($users->toArray()) !!},
                                                    selectedUsers: intialUsers,
                                                    addUser(user){
                                                        if(JSON.parse(JSON.stringify(this.selectedUsers)).length > 0) {
                                                            var found = JSON.parse(JSON.stringify(this.selectedUsers)).filter(function (selectedUser) {
                                                                return selectedUser.uuid == user.uuid;
                                                              });

                                                              if(found.length == 0){
                                                                this.selectedUsers.push(user);
                                                              }
                                                        }else{
                                                            this.selectedUsers.push(user);
                                                        }
                                                    },
                                                    searchForUser(e){
                                                        this.users = this.allUsers.filter(function (user) {
                                                            return user.name.includes(e.target.value);
                                                          });
                                                    }
                                                  }
                                                }
                                            </script>
                                            @error('users')
                                            <div class="text-red-500 text-xs">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="title" class="block text-sm font-medium leading-5 text-gray-700">
                            Title
                        </label>
                        <div class="my-1 rounded-md shadow-sm">
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="form-input border border-gray-300 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('title') border border-red-400 @enderror">
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
                                class="form-input border border-gray-300 shadow-sm block w-full focus:ring-arwad-500 focus:border-arwad-500 sm:text-sm border-gray-300 rounded-md @error('body') border border-red-400 @enderror"></textarea>
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
                        class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-arwad-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        Cancel
                    </button>
                </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-arwad active:bg-arwad-500 transition duration-150 ease-in-out">
                        Create
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
@endsection
