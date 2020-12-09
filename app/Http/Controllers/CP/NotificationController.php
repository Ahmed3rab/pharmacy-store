<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotification;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

    public function create()
    {
        $users = User::all();

        return view('notifications.create')
            ->with('users', $users);
    }

    public function store()
    {
        $data = request()->validate([
            'title'   => 'required|string',
            'body'    => 'required|string',
            'scope'   => 'required|in:all,users',
            'users'   => 'required_if:scope,users|array',
            'users.*' => 'required|exists:users,uuid',
        ]);

        SendNotification::dispatchNow($data);

        return redirect()->route('notifications.create');
    }

    public function show(Notification $notification)
    {
        return view('notifications.show')
            ->with('notification', $notification);
    }
}
