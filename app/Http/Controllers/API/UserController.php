<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function update()
    {
        $data = request()->validate([
            'name'         => 'required|string',
            'phone_number' => 'required|numeric|digits_between:9,10|unique:users,phone_number',
        ]);

        auth()->user()->update([
            'name'         => $data['name'],
            'phone_number' => $data['phone_number'],
        ]);

        return response()->json([], 204);
    }
}
