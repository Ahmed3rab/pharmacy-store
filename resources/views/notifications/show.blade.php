@extends('layouts.app')

@section('header')
<div class="flex justify-between">
    <h1 class="text-2xl font-semibold text-gray-900">
        {{ $notification->title }}
    </h1>
</div>
@endsection
@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-3 sm:p-0">
        <dl>
            <div class="sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Title
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $notification->title }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Body
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $notification->body }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Sent At
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $notification->sent_at->toDateTimeString() }}
                </dd>
            </div>
            <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-5 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-3">
                <dt class="text-sm leading-5 font-medium text-gray-500">
                    Users
                </dt>
                <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                    @if ($notification->sent_to_all)
                    Sent to all users
                    @else
                    @foreach (App\Models\User::whereIn('id', $notification->users)->get() as $user)
                    <a class="hover:text-gray-400" href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                    @endforeach
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection
