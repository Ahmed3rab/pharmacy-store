<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $isAdmin = User::isAdmin($request->email);

        if (Auth::attempt($credentials) && $isAdmin) {
            return redirect()->intended('cp');
        }

        return redirect()->route('login');
    }
}
