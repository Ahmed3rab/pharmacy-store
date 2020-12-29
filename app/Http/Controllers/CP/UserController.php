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
            'type'         => 'required|in:admin,app_user',
            'email'        => 'nullable|required_if:type,admin|unique:users,email',
            'phone_number' => 'nullable|required_if:type,app_user|numeric|digits_between:9,10|unique:users,phone_number',
        ], [
            'email.required_if'        => 'The email field is required if user is an admin.',
            'phone_number.required_if' => 'The phone number field is required if user is an app user.',
        ]);

        if (request('type') == 'admin') {
            $contactType = ['email' => request('email')];
        } else {
            $contactType = ['phone_number' => request('phone_number')];
        }

        User::create(array_merge($contactType, [
            'name'     => request('name'),
            'password' => bcrypt(Str::random(6)),
        ]));

        flash(__('messages.user.create'));

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $user->loadCount('orders');
        $orders = $user->orders()->paginate(8);

        return view('users.show')->with([
            'user'   => $user,
            'orders' => $orders,
        ]);
    }

    public function edit(User $user)
    {
        $type = $user->phone_number ? 'app_user' : 'admin';

        return view('users.edit')->with(['user' => $user, 'type' => $type]);
    }

    public function update(User $user)
    {
        request()->validate([
            'name'         => 'required|string',
            'type'         => 'required|in:admin,app_user',
            'email'        => ['nullable', 'required_if:type,admin', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['nullable', 'required_if:type,app_user', 'numeric', 'digits_between:9,10',  Rule::unique('users', 'phone_number')->ignore($user->id)],
        ], [
            'email.required_if'        => 'The email field is required if user is an admin.',
            'phone_number.required_if' => 'The phone number field is required if user is an app user.',
        ]);

        $user->update([
            'name'         => request('name'),
            'email'        => request('email'),
            'phone_number' => request('phone_number'),
            'password'     => bcrypt(Str::random(6)),
        ]);

        flash(__('messages.user.update'));

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->orders()->delete();
        $user->deviceTokens()->delete();
        $user->activities()->delete();

        $user->delete();

        flash(__('messages.user.delete'));

        return redirect()->route('users.index');
    }
}
