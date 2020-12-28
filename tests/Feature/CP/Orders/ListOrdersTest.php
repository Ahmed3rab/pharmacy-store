<?php

namespace Tests\Feature\CP\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListOrdersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListOrders()
    {
        $this->get(route('orders.index'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListOrders()
    {
        $this->actingAs(User::factory()->create());

        $orders = Order::factory()->times(2)->create();

        $this->get(route('orders.index'))
            ->assertOk()
            ->assertSee($orders->first()->reference_number)
            ->assertSee($orders->first()->user->name)
            ->assertSee($orders->last()->reference_number)
            ->assertSee($orders->last()->user->name);
    }
}
