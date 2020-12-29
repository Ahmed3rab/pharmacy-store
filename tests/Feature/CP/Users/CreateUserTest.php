<?php

namespace Tests\Feature\CP\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUerCanNotCreateUserss()
    {
        $this->get(route('users.create'))->assertRedirect(route('login'));
        $this->post(route('users.store'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewAppUser()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('users.create'))->assertOk();
        $this->post(route('users.store'), [
            'name'         => 'John Doe',
            'type'         => 'app_user',
            'phone_number' => '0911111111',
        ]);

        $this->assertDatabaseHas('users', [
            'name'         => 'John Doe',
            'phone_number' => '0911111111',
        ]);
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewAdmin()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('users.create'))->assertOk();
        $this->post(route('users.store'), [
            'name'  => 'John Doe',
            'type'  => 'admin',
            'email' => 'test@test.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'test@test.com',
        ]);
    }
}
