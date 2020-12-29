<?php

namespace Tests\Feature\CP\Notifications;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListNotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListNotifications()
    {
        $this->get(route('notifications.index'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListNotifications()
    {
        $this->actingAs(User::factory()->create());

        $notifications = Notification::factory()->times(2)->create();

        $this->get(route('notifications.index'))
            ->assertOk()
            ->assertSee($notifications->first()->title)
            ->assertSee($notifications->first()->sent_at->toDateTimeString())
            ->assertSee($notifications->last()->title)
            ->assertSee($notifications->last()->sent_at->toDateTimeString());
    }
}
