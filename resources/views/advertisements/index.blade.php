@extends('layouts.app')

@section('header')
	<div class="flex justify-between items-baseline">
		<h1 class="header-title">
			Advertisements
		</h1>
        <a href="{{ route('advertisements.create') }}" class="text-arwad-500 font-bold text-sm">+ New Advertisement</a>
	</div>
@endsection

@section('content')
	<div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($advertisements as $advertisement)
                                <tr class="{{ $loop->even ? 'bg-gray-50' :  'bg-white'}}">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="{{ $advertisement->imagePath() }}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                {{ $advertisement->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <a href="{{ route('advertisements.edit', $advertisement) }}" class="text-arwad-500 hover:text-indigo-900">Edit</a>
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
