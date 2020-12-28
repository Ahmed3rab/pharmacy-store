<?php

namespace Tests\Feature\API\Orders;

use App\Mail\OrderCreatedMail;
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
    function sendNotificationEmailWhenANewOrderIsCreated()
    {
        Mail::fake();

        $this->actingAs($user = User::factory()->create());

        $products = Product::factory()->times(2)->create();

        $this->post('/api/orders', [
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

        Mail::assertSent(OrderCreatedMail::class);
    }
}
