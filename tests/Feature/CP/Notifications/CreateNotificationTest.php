<?php

namespace Tests\Feature\CP\Notifications;

use App\Models\User;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateNotificationTest extends TestCase
{
    use RefreshDatabase;


    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateNotifications()
    {
        $this->get(route('notifications.create'))->assertRedirect(route('login'));
        $this->post(route('notifications.store'))->assertRedirect(route('login'));
    }

    // TODO:: finsih this test
    // /**
    //  *@test
    //  */
    // function authenticatedUserCanCreateNewNotificationToSendToAllUsers()
    // {
    //     $this->actingAs(User::factory()->create());

    //     $this->get(route('notifications.create'))->assertOk();
    //     $this->post(route('notifications.store'), [
    //         'title'   => $title = 'Testing Notifications',
    //         'body'    => $body = 'Testing Notifications',
    //         'scope'   => 'all',
    //     ])
    //         ->assertSessionDoesntHaveErrors();

    //     $this->assertDatabaseHas('notifications', [
    //         'title'       => $title,
    //         'body'        => $body,
    //         'sent_to_all' => true,
    //         'users'       => null,
    //     ]);
    // }
}
