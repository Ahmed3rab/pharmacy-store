<?php

namespace Tests\Feature\CP\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateUser()
    {
        $user = User::factory()->create();

        $this->get(route('users.edit', $user))->assertRedirect(route('login'));
        $this->patch(route('users.update', $user))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateUser()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->create();

        $this->get(route('users.edit', $user))->assertOk();
        $this->patch(route('users.update', $user), [
            'name'         => 'John Doe',
            'type'         => 'app_user',
            'phone_number' => '0911111111',
        ]);

        $this->assertDatabaseHas('users', [
            'name'         => 'John Doe',
            'phone_number' => '0911111111',
        ]);
    }
}
