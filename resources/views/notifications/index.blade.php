@extends('layouts.app')

@section('header')
<div class="flex justify-between items-baseline">
    <h1 class="header-title">Notifications</h1>
    <a href="{{ route('notifications.create') }}" class="text-arwad-500 font-bold text-sm">+ New Notification</a>
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
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Sent At
                            </th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Users
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                        <tr class="{{ $loop->even ? 'bg-gray-50' :  'bg-white'}}">
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 font-medium text-gray-900">
                                {{ $notification->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $notification->sent_at->toDateTimeString() }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                @if ($notification->sent_to_all)
                                Sent to all users
                                @else
                                @foreach (App\Models\User::whereIn('id', $notification->users)->get() as $user)
                                {{ $user->name }}
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('notifications.show', $notification) }}"
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
