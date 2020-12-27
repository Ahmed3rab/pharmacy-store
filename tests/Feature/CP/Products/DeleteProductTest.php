<?php

namespace Tests\Feature\CP\Products;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotDeleteProduct()
    {
        $product = Product::factory()->create();

        $this->get(route('products.edit', $product))
            ->assertRedirect(route('login'));

        $this->patch(route('products.destroy', $product))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteProduct()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->get(route('products.edit',  $product))
            ->assertStatus(200)
            ->assertViewIs('products.edit');

        $this->delete(route('products.destroy',  $product));

        $this->assertSoftDeleted($product);
    }

    /**
     *@test
     */
    function authenticatedUserCanNotDeleteAProductIfItIsAttachedToAnOrder()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        OrderItem::factory()->create(['product_id' => $product->id]);

        $this->get(route('products.edit',  $product))
            ->assertStatus(200)
            ->assertViewIs('products.edit');

        $this->delete(route('products.destroy',  $product));

        $this->assertDatabaseHas('products', [
            'uuid'       => $product->uuid,
            'deleted_at' => null,
        ]);
    }
}
