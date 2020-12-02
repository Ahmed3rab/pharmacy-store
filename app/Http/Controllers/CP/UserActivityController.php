<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        return view('users.activities', [
            'activities' => $user->actions()->latest()->paginate(10),
            'user' => $user,
        ]);
    }
}
