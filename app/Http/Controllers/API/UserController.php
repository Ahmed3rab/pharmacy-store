<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule; 

class UserController extends Controller
{
    public function update()
    {
        $data = request()->validate([
            'name'         => 'required|string',
            'phone_number' => ['required', 'numeric', 'digits_between:9,10', Rule::unique('users', 'phone_number')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'name'         => $data['name'],
            'phone_number' => $data['phone_number'],
        ]);

        return response()->json([], 204);
    }
}
