<?php

namespace App\Http\Controllers\API;

use App\Exceptions\AppException;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Services\FirebaseUserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;

class LoginController
{
    public function login()
    {
        $data = request()->validate([
            'firebase_user_token' => 'required',
            'device_name'         => 'required',
            'device_token'        => 'required',
        ]);

        try {
            FirebaseUserToken::tokenVerified($data['firebase_user_token']);

            $user = User::firstOrNew(['phone_number' => str_replace('+218', '', FirebaseUserToken::getFirebaseUserPhoneNumber())]);

            if (!$user->exists) {
                $user->fill([
                    'password'                 => bcrypt(Str::random(8)),
                    'phone_number_verified_at' => now(),
                ])->save();

                $user->deviceTokens()->create([
                    'device_name'  => $data['device_name'],
                    'device_token' => $data['device_token'],
                ]);
            }
        } catch (IdTokenVerificationFailed $e) {
            throw new AppException(__('not_found'), 404);
        }

        return response(new AuthResource(
            $user->createToken(request('device_name'))
                ->plainTextToken,
            $user
        ), 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->where('name', request('device_name'))->delete();

        return response(200);
    }
}
