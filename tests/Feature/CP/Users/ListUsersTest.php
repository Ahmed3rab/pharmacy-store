<?php

namespace Tests\Feature\CP\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUerCanNotListUserss()
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListUsers()
    {
        $this->actingAs(User::factory()->create());

        $users = User::factory()->times(2)->create();

        $this->get(route('users.index'))
            ->assertOk()
            ->assertSee($users->first()->name)
            ->assertSee($users->last()->name);
    }
}
