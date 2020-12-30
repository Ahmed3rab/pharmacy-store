@extends('layouts.app')

@section('header')
<div class="flex justify-between">
    <h1 class="text-2xl font-semibold text-gray-900">
        {{ $discount->title }}
    </h1>
    <a href="{{ route('discounts.edit', $discount) }}"
        class="inline-flex items-center px-4 py-2 border border-arwad-500 shadow-sm text-sm font-medium rounded-md text-arwad-500 bg-white hover:bg-arwad-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Edit
    </a>
</div>
@endsection
@section('content')
<img class="w-80 mb-5" src="{{ $discount->coverImagePath() }}" alt="{{ $discount->title }}">

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-3 sm:p-0">
        <dl>
            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Title
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $discount->title }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Percentage
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $discount->percentage }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Starts At
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $discount->starts_at }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Ends At
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $discount->ends_at }}
                </dd>
            </div>
        </dl>
    </div>
</div>
@if ($discount->products->count())
<div class="mt-5 flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price Before
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price After
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Saving
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Options
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discount->products as $product)
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('products.edit', $product) }}">{{ $product->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price_after }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price - $product->price_after }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <form
                                    action="{{ route('discounts-items.destroy', ['discount' => $discount, 'item' => $product->pivot->id]) }}"
                                    method="post">
                                    @method('DELETE')
                                    @csrf

                                    <button type="submit" class="text-red-500 text-xs hover:text-red-600">Remove
                                        Discount
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if ($discount->categories->count())
@foreach ($discount->categories as $category)
<div class="mt-5 flex flex-col">
    <div class="flex justify-between items-center">
        <div class="my-4 text-xl font-semibold">
            {{ $category->name }}:
        </div>
        <form action="{{ route('discounts-items.destroy', ['discount' => $discount, 'item' => $category->pivot->id]) }}"
            method="post">
            @method('DELETE')
            @csrf

            <button type="submit" class="text-red-500 text-xs hover:text-red-600">Remove
                Discount
            </button>
        </form>
    </div>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price Before
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price After
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Saving
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->products as $product)
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('products.edit', $product) }}">{{ $product->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price_after }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product ->price - $product->price_after }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection
