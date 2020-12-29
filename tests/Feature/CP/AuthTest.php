<?php

namespace Tests\Feature\CP;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function GuestsCanLoginToDashboard()
    {
        $user = User::factory()->create(['password' => bcrypt('111111')]);

        $this->get(route('login'))->assertOk();
        $this->post(route('auth.authenticate'), [
            'email'    => $user->email,
            'password' => '111111',
        ])->assertRedirect(route('cp'));

        // wrong password
        $this->post(route('auth.authenticate'), [
            'email'    => $user->email,
            'password' => '9999999',
        ])->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function usersCanLogoutFromDashboard()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
