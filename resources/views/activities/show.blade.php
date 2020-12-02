@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-baseline">
        <h1 class="text-2xl font-semibold text-gray-900">Activity</h1>
    </div>
@endsection

@section('content')
    <!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
  <div class="px-4 py-5 sm:px-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900">
      Activity Information
    </h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">
      Detailed information about the activity
    </p>
  </div>
  <div class="border-t border-gray-200">
    <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Activity Type
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ __("activity_logs.types.{$activity->getExtraProperty('activity_type')}") }}
            </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              User Information
            </dt>
            <dd class="mt-1 text-sm text-indigo-600 sm:mt-0 sm:col-span-2">
              <a class="hover:underline" href="{{ route('users.show', $activity->causer) }}">
                  {{ $activity->causer->name }}
              </a>
            </dd>
        </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          {{ class_basename($activity->subject_type) }}
        </dt>
        <dd class="mt-1 text-sm text-indigo-600 sm:mt-0 sm:col-span-2">
            <a href="{{ $activity->subject->path() }}" class="hover:underline">
                {{ $activity->subject->name }}
            </a>
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Date
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{ $activity->created_at }}
        </dd>
      </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Description
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ $activity->description }}
        </dd>
      </div>
    </dl>
  </div>
</div>
@endsection
