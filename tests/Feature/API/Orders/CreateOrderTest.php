<?php

namespace Tests\Feature\API\Orders;

use App\Mail\OrderCreatedMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateAnOrder()
    {
        $this->post('/api/orders')
            ->assertStatus(401);
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewOrder()
    {
        $this->actingAs(User::factory()->create());

        $products = Product::factory()->times(2)->create();

        $this->post('/api/orders', [
            'notes'      => $notes = 'urgent order',
            'cart_items' => [
                [
                    'product_uuid' => $products->first()->uuid,
                    'quantity'     => 5,
                ],
                [
                    'product_uuid' => $products->last()->uuid,
                    'quantity'     => 13,
                ],
            ],
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('orders', ['notes' => $notes]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $products->first()->id,
            'quantity'     => 5,
        ])
            ->assertDatabaseHas('order_items', [
                'product_id' => $products->last()->id,
                'quantity'   => 13,
            ]);
    }

    /**
     *@test
     */
    function sendNotificationEmailWhenANewOrderIsCreated()
    {
        Mail::fake();

        $this->actingAs(User::factory()->create());

        $products = Product::factory()->times(2)->create();

        $this->post('/api/orders', [
            'cart_items' => [
                [
                    'product_uuid' => $products->first()->uuid,
                    'quantity'     => 5,
                    'price'        => $products->first()->price,
                ],
                [
                    'product_uuid' => $products->last()->uuid,
                    'quantity'     => 13,
                    'price'        => $products->last()->price,
                ],
            ],
        ])
            ->assertStatus(201);

        Mail::assertSent(OrderCreatedMail::class);
    }

    /**
     *@test
     */
    function authenticatedUserCanOrderProductsWhichHasADiscount()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->hasDiscounts(1)->create();

        $this->post('/api/orders', [
            'cart_items' => [
                [
                    'product_uuid' => $product->first()->uuid,
                    'quantity'     => 5,
                ]
            ],
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('order_items', [
            'product_id'  => $product->first()->id,
            'discount_id' => $product->activeDiscount->id,
            'quantity'    => 5,
            'price'       => $product->price_after,
        ]);
    }

    /**
     *@test
     */
    function authenticatedUserCanOrderProductsWhichHasADiscountThroughCategory()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->hasDiscounts(1);
        $product = Product::factory()->for($category)->create();

        $this->post('/api/orders', [
            'cart_items' => [
                [
                    'product_uuid' => $product->first()->uuid,
                    'quantity'     => 5,
                ]
            ],
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('order_items', [
            'product_id'  => $product->first()->id,
            'discount_id' => $product->activeDiscount->id,
            'quantity'    => 5,
            'price'       => $product->price_after,
        ]);
    }
}
