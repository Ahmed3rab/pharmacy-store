<?php

namespace Tests\Feature\CP\Users;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotViewUserDetails()
    {
        $user = User::factory()->create();

        $this->get(route('users.show', $user))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanViewUserDetails()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->hasOrders()->create();

        $this->get(route('users.show', $user))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee($user->orders->first()->reference_number)
            ->assertSee($user->orders->last()->reference_number);
    }
}
