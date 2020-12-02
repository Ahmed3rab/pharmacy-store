<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')->latest()->paginate(10);

        return view('users.index')->with('users', $users);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        request()->validate([
            'name'         => 'required|string',
            'email'        => 'nullable|required_if:phone_number,',
            'phone_number' => 'nullable|required_if:email,|numeric|digits_between:9,10|unique:users,phone_number',
        ], [
            'email.required_if'        => 'The email field is required when phone number is empty.',
            'phone_number.required_if' => 'The phone number field is required when email is empty.',
        ]);

        User::create([
            'name'         => request('name'),
            'email'        => request('email'),
            'phone_number' => request('phone_number'),
            'password'     => bcrypt(Str::random(6)),
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);
    }

    public function update(User $user)
    {
        request()->validate([
            'name'         => 'required|string',
            'email'        => 'nullable|required_if:phone_number,',
            'phone_number' => ['nullable', 'required_if:email,', 'numeric', 'digits_between:9,10',  Rule::unique('users', 'phone_number')->ignore($user->id)],
        ], [
            'email.required_if'        => 'The email field is required when phone number is empty.',
            'phone_number.required_if' => 'The phone number field is required when email is empty.',
        ]);

        $user->update([
            'name'         => request('name'),
            'email'        => request('email'),
            'phone_number' => request('phone_number'),
            'password'     => bcrypt(Str::random(6)),
        ]);

        return redirect()->route('users.index');
    }
}
