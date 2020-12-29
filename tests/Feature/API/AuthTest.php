<?php

namespace Tests\Feature\API;

use App\Models\User;
use App\Services\FirebaseUserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function it_registers_new_user_by_phone_number_verification()
    {
        $this->withFakeFirebaseUserWithPhoneNumberOf('910000000');

        $response = $this->post('/api/auth/token', [
            'firebase_user_token' => '9999999',
            'device_name'         => 'testing',
            'device_token'        => 'testing',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'user' => [
                        'uuid',
                        'phone_number',
                        'name',
                        'email',
                    ],
                ],
            ]);

        $user = User::first();

        $this->assertDatabaseHas('users', [
            'phone_number' => $user->phone_number,
        ]);

        $this->assertDatabaseHas('user_device_tokens', [
            'user_id'      => $user->id,
            'device_name'  => 'testing',
            'device_token' => 'testing',
        ]);
    }

    /**
     *@test
     */
    function it_logs_in_existing_user_by_phone_number_verification()
    {
        User::factory()->create(['phone_number' => '910000000']);

        $this->withFakeFirebaseUserWithPhoneNumberOf('910000000');

        $this->post('/api/auth/token', [
            'firebase_user_token' => '9999999',
            'device_name'         => 'testing',
            'device_token'        => 'testing',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'user' => [
                        'uuid',
                        'phone_number',
                        'name',
                        'email',
                    ],
                ]
            ]);

        $this->assertDatabaseCount('users', 1);
    }

    function withFakeFirebaseUserWithPhoneNumberOf($phoneNumber)
    {
        $mock = Mockery::mock('alias:' . FirebaseUserToken::class);
        $mock->shouldReceive('tokenVerified')
            ->once()
            ->andReturn(true);

        $mock->shouldReceive('getFirebaseUserPhoneNumber')
            ->once()
            ->andReturn('+218' . $phoneNumber);

        $this->app->instance(FirebaseUserToken::class, $mock);
    }
}
