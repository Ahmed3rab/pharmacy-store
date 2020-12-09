@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Product Discount: {{ $discount->title }}</h1>
</div>
@endsection

@section('content')
<div class="shadow bg-white p-6">

    <form action="{{ route('discounts.update', $discount) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <div class="w-1/2 mb-5">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $discount->title) }}"
                class="form-input border border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md @error('title') border border-red-400 @enderror">

            @error('title')
            <div class="text-red-500 text-xs">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-1/2 mb-5">
            <label for="percentage" class="block text-sm font-medium text-gray-700">Percentage</label>
            <input type="number" min="1" max="100" name="percentage" id="percentage"
                value="{{ old('percentage', $discount->percentage) }}"
                class="form-input border border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm @error('percentage') border border-red-400 @enderror rounded-md">

            @error('percentage')
            <div class="text-red-500 text-xs">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-1/2 mb-5">
            <label for="starts_at" class="block text-sm font-medium text-gray-700">Start At</label>
            <input type="date" name="starts_at" id="starts_at"
                value="{{ old('starts_at', $discount->starts_at->toDateString()) }}"
                class="form-input border border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm @error('starts_at') border border-red-400 @enderror rounded-md">

            @error('starts_at')
            <div class="text-red-500 text-xs">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-1/2 mb-5">
            <label for="ends_at" class="block text-sm font-medium text-gray-700">Ends At</label>
            <input type="date" name="ends_at" id="ends_at"
                value="{{ old('ends_at', $discount->ends_at->toDateString()) }}"
                class="form-input border border-gray-300 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm @error('ends_at') border border-red-400 @enderror rounded-md">

            @error('ends_at')
            <div class="text-red-500 text-xs">{{ $message }}</div>
            @enderror
        </div>

        <div x-data="{ tab: '{{ count($selectedProducts)? 'product' : 'category' }}' }"
            class="flex flex-col justify-between space-y-5">
            <div class="">
                <fieldset>
                    <legend id="radiogroup-label" class="sr-only">
                        Server size
                    </legend>
                    <ul class="flex space-x-4" role="radiogroup" aria-labelledby="radiogroup-label">
                        <li @click="tab = 'category'" id="radiogroup-option-1" tabindex="-1" role="radio"
                            aria-checked="false"
                            class="group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-indigo-500">
                            <div
                                class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between @error('category') border border-red-400 @enderror">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900">
                                            Category
                                        </p>
                                        <div class="text-gray-500">
                                            <p class="sm:inline">Add discount to specific category products</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                :class="{ 'border-indigo-500': tab === 'category', 'border-transparent': tab != 'category' }"
                                aria-hidden="true"></div>
                        </li>

                        <li @click="tab = 'product'" id="radiogroup-option-2" tabindex="-1" role="radio"
                            aria-checked="false"
                            class="group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-indigo-500">
                            <d
                                class="rounded-lg border border-gray-300 bg-white px-6 py-4 hover:border-gray-400 sm:flex sm:justify-between @error('products') border border-red-400 @enderror">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900">
                                            Products
                                        </p>
                                        <div class="text-gray-500">
                                            <p class="sm:inline">Add discount to specific products</p>
                                        </div>
                                    </div>
                                </div>
                            </d iv>
                            <div class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                :class="{ 'border-indigo-500': tab === 'product', 'border-transparent': tab != 'product' }"
                                aria-hidden="true"></div>
                        </li>
                    </ul>
                </fieldset>

            </div>
            <div class="w-1/2 border border-gray-200 rounded p-8">
                <template x-if="tab == 'category'">
                    <div class="space-y-4">
                        <div x-data="component({{ old('categories')? \App\Models\Category::whereIn('uuid', old('categories'))->get() : $selectedCategories }})"
                            class="flex flex-col items-center mx-auto">
                            <div class="w-full">
                                <label for="categories"
                                    class="block text-sm font-medium text-gray-700">Categories</label>

                                <div class="flex flex-col items-center relative">
                                    <div class="w-full  svelte-1l8159u">
                                        <div
                                            class="my-2 p-1 flex border border-gray-200 @error('categories') border border-red-400 @enderror bg-white rounded svelte-1l8159u">
                                            <div class="flex flex-auto flex-wrap">
                                                <template x-for="(selectedCategory, index) in selectedCategories">
                                                    <div
                                                        class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-white bg-arwad-500">
                                                        <div class="text-xs font-normal leading-none max-w-full flex-initial"
                                                            x-text="selectedCategory.name"></div>

                                                        <input type="hidden" name="categories[]"
                                                            x-bind:value="selectedCategory.uuid">

                                                        <div class="flex flex-auto flex-row-reverse">
                                                            <div @click="selectedCategories.splice(index, 1)">
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
                                            class="absolute shadow top-12 bg-white z-40 w-full lef-0 rounded max-h-52 overflow-y-auto svelte-5uyqqj">
                                            <div class="flex flex-col w-full">
                                                @foreach ($categories as $category)
                                                <div
                                                    class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:text-arwad-500">
                                                    <div
                                                        class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-gray-200">
                                                        <div class="w-full items-center flex">
                                                            <div @click="addCategory({{ $category }})"
                                                                class="mx-2 leading-6">{{ $category->name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <script>
                                    function component(intialCategories) {
                                      return {
                                        open: false,
                                        selectedCategories: intialCategories,
                                        addCategory(category){
                                            if(JSON.parse(JSON.stringify(this.selectedCategories)).length > 0) {
                                                var found = JSON.parse(JSON.stringify(this.selectedCategories)).filter(function (selectedCategory) {
                                                    return selectedCategory.uuid == category.uuid;
                                                  });

                                                  if(found.length == 0){
                                                    this.selectedCategories.push(category);
                                                  }
                                            }else{
                                                this.selectedCategories.push(category);
                                            }
                                        }
                                      }
                                    }
                                </script>

                                @error('categories')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                                @error('categories.*')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="tab == 'product'">
                    <div class="space-y-4">
                        <div x-data="component({{ old('products')? \App\Models\Product::whereIn('uuid', old('products'))->get() : $selectedProducts }})"
                            class="flex flex-col items-center mx-auto">
                            <div class="w-full">
                                <label for="products" class="block text-sm font-medium text-gray-700"
                                    @click="alert(selectedProducts[2])">Products</label>

                                <div class="flex flex-col items-center relative">
                                    <div class="w-full svelte-1l8159u">
                                        <div
                                            class="my-2 p-1 flex border border-gray-200 @error('products') border border-red-400 @enderror bg-white rounded svelte-1l8159u">
                                            <div class="flex flex-auto flex-wrap">
                                                <template x-for="(selectedProduct, index) in selectedProducts">
                                                    <div
                                                        class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-white bg-arwad-500">
                                                        <div class="text-xs font-normal leading-none max-w-full flex-initial"
                                                            x-text="selectedProduct.name"></div>
                                                        <input type="hidden" name="products[]"
                                                            x-bind:value="selectedProduct.uuid">
                                                        <div class="flex flex-auto flex-row-reverse">
                                                            <div @click="selectedProducts.splice(index, 1)">
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
                                            class="absolute shadow top-12 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
                                            <div class="flex flex-col w-full">
                                                @foreach ($products as $product)
                                                <div
                                                    class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:text-arwad-500">
                                                    <div
                                                        class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-gray-200">
                                                        <div class="w-full items-center flex">
                                                            <div @click="addProduct({{ $product }})"
                                                                class="mx-2 leading-6">{{ $product->name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <script>
                                    function component(intialProducts) {
                                      return {
                                        open: false,
                                        selectedProducts: intialProducts,
                                        addProduct(product){
                                            if(JSON.parse(JSON.stringify(this.selectedProducts)).length > 0) {
                                                var found = JSON.parse(JSON.stringify(this.selectedProducts)).filter(function (selectedProduct) {
                                                    return selectedProduct.uuid == product.uuid;
                                                  });

                                                  if(found.length == 0){
                                                    this.selectedProducts.push(product);
                                                  }
                                            }else{
                                                this.selectedProducts.push(product);
                                            }
                                        }
                                      }
                                    }
                                </script>
                                @error('products')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                                @error('products.*')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </template>
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
                        Update
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

<div class="my-3 flex justify-end">
    <form action="{{ route('discounts.destroy', $discount) }}" method="POST">
        @csrf
        @method('DELETE')
        <span class="inline-flex">
            <button type="submit"
                class="py-2 text-sm leading-5 font-medium text-red-500 hover:text-red-300 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                Delete This Discount
            </button>
        </span>
    </form>
</div>
@endsection
