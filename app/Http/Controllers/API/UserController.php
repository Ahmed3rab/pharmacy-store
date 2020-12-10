<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function update()
    {
        $data = request()->validate([
            'name' => 'required|string',
        ]);

        auth()->user()->update([
            'name' => $data['name'],
        ]);

        return response()->json([], 204);
    }
}
