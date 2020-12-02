<a href="{{ route('users.show', $activity->causer) }}" class="text-sm text-indigo-600 hover:underline">
    <span class="truncate">{{ $activity->causer->name }}</span>
</a>
<span>
    {{ __("activity_logs.types.{$activity->getExtraProperty('activity_type')}") }}
</span>
<a class="text-sm text-indigo-600 hover:underline" href="{{ $activity->subject->path() }}">{{ $activity->subject->name }}</a>
