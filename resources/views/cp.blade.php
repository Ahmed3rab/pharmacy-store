@extends('layouts.app')

@section('content')
<div>
    <div x-data="{ open: false, orderTimeScope: '{{ ucfirst(str_replace('_', ' ', request('orders_time_scope'))) ?: 'All time' }}' }"
        class="relative inline-block text-left">
        <div>
            <button type="button" @click="open = !open"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                id="options-menu" aria-haspopup="true" aria-expanded="true">
                <span x-text="orderTimeScope"></span>
                <!-- Heroicon name: chevron-down -->
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <a href="{{ route('cp') }}?orders_time_scope=this_month"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem">This month</a>
                <a href="{{ route('cp') }}?orders_time_scope=last_month"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem">Last month</a>
                <a href="{{ route('cp') }}?orders_time_scope=this_year"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem">This year</a>
                <a href="{{ route('cp') }}?orders_time_scope=all_time"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem">All time</a>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-arwad-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                Total Open Orders
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl leading-8 font-semibold text-gray-900">
                                    {{ $pendingOrdersCount }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm leading-5">
                    <a href="{{ route('orders.index') }}?status=pending"
                        class="font-medium text-arwad-500 hover:text-arwad-500 transition ease-in-out duration-150">
                        View all
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-arwad-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                Total Completed Orders
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl leading-8 font-semibold text-gray-900">
                                    {{ $completedOrdersCount }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm leading-5">
                    <a href="{{ route('orders.index') }}?status=completed"
                        class="font-medium text-arwad-500 hover:text-arwad-500 transition ease-in-out duration-150">
                        View all
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-arwad-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                Total Orders
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl leading-8 font-semibold text-gray-900">
                                    {{ $ordersCount }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-sm leading-5">
                    <a href="{{ route('orders.index') }}"
                        class="font-medium text-arwad-500 hover:text-arwad-500 transition ease-in-out duration-150">
                        View all
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
