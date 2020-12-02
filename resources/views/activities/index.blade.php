@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="text-2xl font-semibold text-gray-900">Activities</h1>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @forelse ($activities as $activity)
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
        @empty
            <li class="text-center py-4 text-lg font-medium text-gray-600 truncate">
                No Activities
            </li>
        @endforelse
    </ul>
    @if($activities->count() > 0)
        <div class="px-5 py-3 border-t border-gray-200">{{ $activities->links() }}</div>
    @endif
</div>
@endsection
