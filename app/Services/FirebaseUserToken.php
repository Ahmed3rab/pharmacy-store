<?php

namespace App\Services;

use Kreait\Firebase\JWT\IdTokenVerifier;

class FirebaseUserToken
{
    static private $token;

    public static function tokenVerified($token)
    {
        $verifier = IdTokenVerifier::createWithProjectId(config('services.firebase.project_id'));

        static::$token = $verifier->verifyIdTokenWithLeeway($token, 60);

        return !!static::$token;
    }

    public static function getFirebaseUserPhoneNumber()
    {
        return static::$token->payload()['phone_number'];
    }
}