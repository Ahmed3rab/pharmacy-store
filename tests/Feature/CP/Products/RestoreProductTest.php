<?php

namespace Tests\Feature\CP\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotDeleteProduct()
    {
        $product = Product::factory()->create()->delete();

        $this->get(route('products.edit', $product))
            ->assertRedirect(route('login'));

        $this->post(route('products.restore', $product))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteProduct()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $product->delete();

        $this->assertNotEmpty($product->deleted_at);

        $this->get(route('products.edit',  $product))
            ->assertStatus(200)
            ->assertViewIs('products.edit');

        $this->post(route('products.restore',  $product));

        $this->assertDatabaseHas('products', [
            'uuid'       => $product->uuid,
            'deleted_at' => null,
        ]);
    }
}
