<?php

namespace Tests\Feature\API\Orders;

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
        $this->get('/api/orders')
            ->assertStatus(401);
    }

    /**
     *@test
     */
    function authenticatedUsersCanListTheirOwnItems()
    {
        $this->actingAs($user = User::factory()->create());

        $orders = Order::factory()->count(2)->hasItems(2)
            ->create(['user_id' => $user->id]);

        $this->get('/api/orders')
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    [
                        'uuid'                       => $orders->first()->uuid,
                        'reference_number'           => $orders->first()->reference_number,
                        'order_items_count'          => $orders->first()->items()->count(),
                        'order_items_quantity_count' => $orders->first()->items()->sum('quantity'),
                        'created_at'                 => $orders->first()->created_at,
                        'is_complete'                => $orders->first()->isComplete(),
                        'notes'                      => $orders->first()->notes,
                    ],
                    [
                        'uuid'                       => $orders->last()->uuid,
                        'reference_number'           => $orders->last()->reference_number,
                        'order_items_count'          => $orders->last()->items()->count(),
                        'order_items_quantity_count' => $orders->last()->items()->sum('quantity'),
                        'created_at'                 => $orders->last()->created_at,
                        'is_complete'                => $orders->last()->isComplete(),
                        'notes'                      => $orders->last()->notes,
                    ],
                ],
            ]);
    }
}
