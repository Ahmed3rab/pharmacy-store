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
    function authenticatedUsersCanListTheirOwnOrders()
    {
        $this->actingAs($user = User::factory()->create());

        $orders = Order::factory()->count(2)->hasItems(2)
            ->create(['user_id' => $user->id]);

        $anotherUserOrder = Order::factory()->create();

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
                        'status'                     => $orders->first()->status,
                        'notes'                      => $orders->first()->notes,
                        'total'                      => $orders->first()->items->sum('total'),
                        'items'                      => [
                            [
                                'price'    => $orders->first()->items->first()->price,
                                'quantity' => $orders->first()->items->first()->quantity,
                                'product'  => [
                                    'uuid'        => $orders->first()->items->first()->product->uuid,
                                    'image_path'  => $orders->first()->items->first()->product->imagePath(),
                                    'name'        => $orders->first()->items->first()->product->name,
                                    'position'    => $orders->first()->items->first()->product->position,
                                    'description' => $orders->first()->items->first()->product->description,
                                    'quantity'    => $orders->first()->items->first()->product->quantity,
                                    'item_price'  => (float) $orders->first()->items->first()->product->item_price,
                                    'price'       => (float) $orders->first()->items->first()->product->price,
                                    'price_after' => (float) $orders->first()->items->first()->product->price_after,
                                    'discount'    => null,
                                ],
                                'discount' => null,
                            ],
                            [
                                'price'    => $orders->first()->items->last()->price,
                                'quantity' => $orders->first()->items->last()->quantity,
                                'product'  => [
                                    'uuid'        => $orders->first()->items->last()->product->uuid,
                                    'image_path'  => $orders->first()->items->last()->product->imagePath(),
                                    'name'        => $orders->first()->items->last()->product->name,
                                    'position'    => $orders->first()->items->last()->product->position,
                                    'description' => $orders->first()->items->last()->product->description,
                                    'quantity'    => $orders->first()->items->last()->product->quantity,
                                    'item_price'  => (float) $orders->first()->items->last()->product->item_price,
                                    'price'       => (float) $orders->first()->items->last()->product->price,
                                    'price_after' => (float) $orders->first()->items->last()->product->price_after,
                                    'discount'    => null,
                                ],
                                'discount' => null,
                            ],
                        ],
                    ],
                    [
                        'uuid'                       => $orders->last()->uuid,
                        'reference_number'           => $orders->last()->reference_number,
                        'order_items_count'          => $orders->last()->items()->count(),
                        'order_items_quantity_count' => $orders->last()->items()->sum('quantity'),
                        'created_at'                 => $orders->last()->created_at,
                        'is_complete'                => $orders->last()->isComplete(),
                        'status'                     => $orders->last()->status,
                        'notes'                      => $orders->last()->notes,
                        'total'                      => $orders->last()->items->sum('total'),
                        'items'                      => [
                            [
                                'price'    => $orders->last()->items->first()->price,
                                'quantity' => $orders->last()->items->first()->quantity,
                                'product'  => [
                                    'uuid'        => $orders->last()->items->first()->product->uuid,
                                    'image_path'  => $orders->last()->items->first()->product->imagePath(),
                                    'name'        => $orders->last()->items->first()->product->name,
                                    'position'    => $orders->last()->items->first()->product->position,
                                    'description' => $orders->last()->items->first()->product->description,
                                    'quantity'    => $orders->last()->items->first()->product->quantity,
                                    'item_price'  => (float) $orders->last()->items->first()->product->item_price,
                                    'price'       => (float) $orders->last()->items->first()->product->price,
                                    'price_after' => (float) $orders->last()->items->first()->product->price_after,
                                    'discount'    => null,
                                ],
                                'discount' => null,
                            ],
                            [
                                'price'    => $orders->last()->items->last()->price,
                                'quantity' => $orders->last()->items->last()->quantity,
                                'product'  => [
                                    'uuid'        => $orders->last()->items->last()->product->uuid,
                                    'image_path'  => $orders->last()->items->last()->product->imagePath(),
                                    'name'        => $orders->last()->items->last()->product->name,
                                    'position'    => $orders->last()->items->last()->product->position,
                                    'description' => $orders->last()->items->last()->product->description,
                                    'quantity'    => $orders->last()->items->last()->product->quantity,
                                    'item_price'  => (float) $orders->last()->items->last()->product->item_price,
                                    'price'       => (float) $orders->last()->items->last()->product->price,
                                    'price_after' => (float) $orders->last()->items->last()->product->price_after,
                                    'discount'    => null,
                                ],
                                'discount' => null,
                            ],
                        ],
                    ],
                ],
            ])
            ->assertDontSee($anotherUserOrder->uuid);
    }
}
