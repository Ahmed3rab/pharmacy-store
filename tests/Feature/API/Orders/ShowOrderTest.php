<?php

namespace Tests\Feature\API\Orders;

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
    function unauthenticatedUserCanNotShowAnOrder()
    {
        $order = Order::factory()->create();

        $this->get("/api/orders/{$order->uuid}")
            ->assertStatus(401);
    }

    /**
     *@test
     */
    function authenticatedUsersCanNotViewOrderTheyDontOwn()
    {
        $this->actingAs(User::factory()->create());

        $order = Order::factory()->create();

        $this->get("/api/orders/{$order->uuid}")
            ->assertStatus(403);
    }

    /**
     *@test
     */
    function authenticatedUsersCanViewTheirOwnOrder()
    {
        $this->actingAs($user = User::factory()->create());

        $order = Order::factory()->hasItems()->create(['user_id' => $user->id]);

        $this->get("/api/orders/{$order->uuid}")
            ->assertStatus(200)
            ->assertJsonFragment(['data' => [
                'uuid'                       => $order->uuid,
                'reference_number'           => $order->reference_number,
                'order_items_count'          => $order->items()->count(),
                'order_items_quantity_count' => $order->items()->sum('quantity'),
                'created_at'                 => $order->created_at,
                'is_complete'                => $order->isComplete(),
                'notes'                      => $order->notes,
                'total'                      => $order->items->sum('total'),
                'items' => [
                    [
                        'price'    => $order->items->first()->price,
                        'quantity' => $order->items->first()->quantity,
                        'product'  => [
                            'uuid'        => $order->items->first()->product->uuid,
                            'image_path'  => $order->items->first()->product->imagePath(),
                            'name'        => $order->items->first()->product->name,
                            'position'    => $order->items->first()->product->position,
                            'description' => $order->items->first()->product->description,
                            'quantity'    => $order->items->first()->product->quantity,
                            'item_price'  => (float) $order->items->first()->product->item_price,
                            'price'       => (float) $order->items->first()->product->price,
                            'price_after' => (float) $order->items->first()->product->price_after,
                            'discount'    => null,
                        ],
                        'discount' => null,
                    ],
                ],
            ],]);
    }
}
