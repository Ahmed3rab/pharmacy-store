@extends('layouts.app')

@section('header')
<div class="flex justify-between">
    <h1 class="text-2xl font-semibold text-gray-900">
        {{ $user->name }}
    </h1>

    <a href="{{ route('users.edit', $user) }}"
        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-500 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
        Edit
    </a>
</div>
@endsection
@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-3 sm:p-0">
        <dl>
            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Name
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $user->name }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Email
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $user->email }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Phone Number
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $user->phone_number }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Joined At
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $user->created_at->toDateString() }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Orders Made
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $user->orders_count }}
                </dd>
            </div>
        </dl>
    </div>
</div>

@if($user->orders->count())
<div class="mt-5 flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order Referance Number
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Made On
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Products Count
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->orders as $order)
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('orders.show', $order) }}">{{ $order->reference_number }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->toDateString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->items->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->items->sum('total') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@else
<div class="bg-white p-5 my-5 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg text-gray-500 font-semibold">
    No Order Made.
</div>
@endempty

@if($user->actions->count() > 0)
    <div class="mt-5">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach ($user->actions()->latest()->take(5)->get() as $activity)
                    <li>
                        <button onclick="window.location = '{{ route('activities.show', $activity) }}'" class="w-full block hover:bg-gray-50">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                        <div class="text-sm text-left font-medium text-gray-500 truncate">
                                            @include("activities.partials._{$activity->getExtraProperty('activity_type')}")
                                        </div>
                                        <div class="hidden md:block text-right">
                                            <div>
                                                <p class="text-sm text-gray-900">
                                                    <time datetime="2020-01-07">{{ $activity->created_at->diffForHumans() }}</time>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <!-- Heroicon name: chevron-right -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('users.activities.show', $user) }}" class="flex justify-end text-indigo-600 mt-4 hover:underline">
            View All Activities
        </a>
    </div>

@endif
@endsection
