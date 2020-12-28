<?php

namespace Tests\Feature\CP\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToggleOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotToggleOrderStatus()
    {
        $order = Order::factory()->create();

        $this->post(route('orders.complete.store', $order))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanToggleOrderStatus()
    {
        $this->actingAs(User::factory()->create());

        $order = Order::factory()->create();

        $this->post(route('orders.complete.store', $order));

        $this->assertNotEmpty($order->fresh()->completed_at);

        $this->post(route('orders.pending.store', $order));

        $this->assertEmpty($order->fresh()->completed_at);
    }
}
