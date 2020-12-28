<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function update()
    {
        $data = request()->validate([
            'name'         => 'required|string',
            'phone_number' => ['required', 'numeric', 'regex:/^09[1245][0-9]{7}$/', 'digits:10', Rule::unique('users', 'phone_number')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'name'         => $data['name'],
            'phone_number' => $data['phone_number'],
        ]);

        return new UserResource(auth()->user());
    }
}
