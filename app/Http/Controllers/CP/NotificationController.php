<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotification;
use App\Models\User;

class NotificationController extends Controller
{
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
            'users'   => 'required|array',
            'users.*' => 'required|exists:users,uuid',
        ]);

        SendNotification::dispatchNow($data);

        return redirect()->route('notifications.create');
    }
}
