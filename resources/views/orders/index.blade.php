@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Orders</h1>
</div>
@endsection

@section('content')
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">

        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="bg-white py-5 px-5 rounded-lg shadow-sm my-5">
                <h3 class="text-2xl mb-5">Filter</h3>
                <form action="{{ route('orders.index') }}" method="get">
                    <div class="grid grid-cols-4 gap-4 space-x-2">
                        <div>
                            <div class="text-sm font-semibold mb-2">Status</div>
                            <div x-data="{ status: '{{ request()->status?: '' }}' }">
                                <input type="hidden" name="status" x-model="status">

                                <button type="button" @click="status = 'pending'"
                                    class="shadow inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium leading-5 text-yellow-800"
                                    :class="status == 'pending' ? 'bg-yellow-100' : 'bg-white'">
                                    Pending
                                </button>
                                <button type="button" @click="status = 'completed'"
                                    class="shadow inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium leading-5 text-green-800"
                                    :class="status == 'completed' ? 'bg-green-100' : 'bg-white'">
                                    Completed
                                </button>
                            </div>

                        </div>
                        <div x-data="{ open: false, orderTimeScope: '', orderTimeScopeText: '{{ ucfirst(str_replace('_', ' ', request('orders_time_scope'))) ?: 'All time' }}' }"
                            class="relative w-36 inline-block text-left">
                            <input type="hidden" name="orders_time_scope" x-model="orderTimeScope">

                            <div class="text-sm font-semibold mb-2">Time Scope</div>
                            <div>
                                <button type="button" @click="open = !open"
                                    class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                                    id="options-menu" aria-haspopup="true" aria-expanded="true">
                                    <span x-text="orderTimeScopeText"></span>
                                    <!-- Heroicon name: chevron-down -->
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1" role="menu" aria-orientation="vertical"
                                    aria-labelledby="options-menu">
                                    <button type="button"
                                        @click="orderTimeScope = 'this_month', orderTimeScopeText = 'This month'"
                                        class="w-full block text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">This month</button>
                                    <button type="button"
                                        @click="orderTimeScope = 'last_month',  orderTimeScopeText = 'Last month'"
                                        class="w-full block text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">Last month</button>
                                    <button type="button"
                                        @click="orderTimeScope = 'this_year',  orderTimeScopeText = 'This year'"
                                        class="w-full block text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">This year</button>
                                    <button type="button"
                                        @click="orderTimeScope = 'all_time',  orderTimeScopeText = 'All time'"
                                        class="w-full block text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">All time</button>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>

                    <button class="text-xs font-medium mt-5 bg-arwad-500 rounded text-white py-2 px-2">Show
                        Results</button>
                </form>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Products Count
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Products Total Quantity
                            </th>
                            <th
                                class="text-center px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="{{ $loop->even ? 'bg-gray-50' :  'bg-white'}}">
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                {{ $order->reference_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $order->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $order->items_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $order->items_total_quantity }}
                            </td>
                            <td class="text-center px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                @if($order->isComplete())
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-green-100 text-green-800">
                                    Completed
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="{{ route('orders.show', $order) }}"
                                    class="text-arwad-500 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
