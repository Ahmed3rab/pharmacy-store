<?php

namespace Tests\Feature\CP\Notifications;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotShowANotification()
    {
        $notification = Notification::factory()->create();

        $this->get(route('notifications.show', $notification))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListNotifications()
    {
        $this->actingAs(User::factory()->create());

        $notification = Notification::factory()->create();

        $this->get(route('notifications.show', $notification))
            ->assertOk()
            ->assertSee($notification->title)
            ->assertSee($notification->sent_at->toDateTimeString())
            ->assertSee($notification->title)
            ->assertSee($notification->sent_at->toDateTimeString());
    }
}
