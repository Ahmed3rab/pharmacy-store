<?php

namespace Tests\Feature\CP\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListProducts()
    {
        $this->get(route('products.index'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUsersCanListProducts()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->get(route('products.index'))
            ->assertStatus(200)
            ->assertViewIs('products.index')
            ->assertSee($product->name)
            ->assertSee($product->position)
            ->assertSee($product->price)
            ->assertSee($product->category->name);
    }
}
