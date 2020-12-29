<?php

namespace Tests\Feature\CP\Users;

use App\Models\Product;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotDeleteUser()
    {
        $user = User::factory()->create();

        $this->get(route('users.edit', $user))->assertRedirect(route('login'));
        $this->delete(route('users.destroy', $user))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteUserAndItsAttachedRecords()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->hasOrders()->create();

        UserDeviceToken::create([
            'user_id'      => $user->id,
            'device_name'  => 'test',
            'device_token' => 'test',
        ]);

        activity()->by($user)
            ->on($subject = Product::factory()->create())
            ->withProperties(['activity_type' => 'view_product'])
            ->log(__("activity_logs.view_product", ['user' => $user->name, 'subject' => $subject->name]));

        $this->get(route('users.edit', $user))->assertOk();
        $this->delete(route('users.destroy', $user))->assertRedirect(route('users.index'));

        $this->assertDeleted($user);
    }
}
