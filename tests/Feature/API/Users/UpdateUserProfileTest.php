<?php

namespace Tests\Feature\API\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateProfile()
    {
        $this->patch('/api/user')->assertStatus(401);
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateTheirOwnProfiles()
    {
        $this->actingAs(User::factory()->create());

        $this->patch('/api/user', [
            'name'         => 'Test Name',
            'phone_number' => '0911111111',
        ])->assertStatus(200);
    }
}
