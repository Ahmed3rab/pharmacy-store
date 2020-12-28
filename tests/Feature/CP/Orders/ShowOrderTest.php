<?php

namespace Tests\Feature\CP\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListOrders()
    {
        $order = Order::factory()->create();

        $this->get(route('orders.show', $order))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListOrders()
    {
        $this->actingAs(User::factory()->create());

        $order = Order::factory()->hasItems(2)->create();

        $this->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee($order->reference_number)
            ->assertSee($order->user->name)
            ->assertSee($order->items->first()->quantity)
            ->assertSee($order->items->first()->product->name)
            ->assertSee($order->items->last()->quantity)
            ->assertSee($order->items->last()->product->name);
    }
}
