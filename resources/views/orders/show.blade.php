@extends('layouts.app', ['pageTitle' => 'Order:' .  $order->reference_number ])

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-3 sm:p-0">
            <dl>
                <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6 sm:py-3">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Reference Number
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->reference_number }}
                    </dd>
                </div>
                <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        User
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->user->name }}
                    </dd>
                </div>
                <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($order->isComplete())
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-green-100 text-green-800">
                              Completed
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-yellow-100 text-yellow-800">
                              Pending
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Products Count
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->items->count() }}
                    </dd>
                </div>
                <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                    <dt class="text-sm leading-5 font-medium text-gray-500">
                        Products Total Quantity
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->items->sum('quantity') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    @if(!$order->isComplete())
        <div class="mt-5">
            <form action="{{ route('orders.complete.store', $order) }}" method="POST">
                @method('PATCH')
                @csrf
                <span class="inline-flex rounded-md shadow-sm">
                  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-arwad-700 focus:shadow-outline-arwad active:bg-arwad-700 transition ease-in-out duration-150">
                    Mark as Complete
                  </button>
                </span>
            </form>
        </div>
    @endif

@endsection