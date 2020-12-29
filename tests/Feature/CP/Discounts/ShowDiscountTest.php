<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowDiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanViewADiscount()
    {
        $discount = Discount::factory()->create();

        $this->get(route('discounts.show', $discount))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanShowiscountWithItsCategories()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()
            ->hasAttached(Category::factory()->hasProducts(1)->count(2))
            ->create();

        $this->get(route('discounts.show', $discount))
            ->assertOk()
            ->assertSee($discount->title)
            ->assertSee($discount->precentage)
            ->assertSee($discount->categories->first()->products->first()->name)
            ->assertSee($discount->categories->first()->products->first()->price)
            ->assertSee($discount->categories->first()->products->first()->price_after)
            ->assertSee($discount->categories->first()->products->last()->name)
            ->assertSee($discount->categories->first()->products->last()->price)
            ->assertSee($discount->categories->first()->products->last()->price_after)
            ->assertSee($discount->categories->last()->products->first()->name)
            ->assertSee($discount->categories->last()->products->first()->price)
            ->assertSee($discount->categories->last()->products->first()->price_after)
            ->assertSee($discount->categories->last()->products->last()->name)
            ->assertSee($discount->categories->last()->products->last()->price)
            ->assertSee($discount->categories->last()->products->last()->price_after);
    }

    /**
     *@test
     */
    function authenticatedUserCanShowDiscountWithItsProducts()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()
            ->hasAttached(Product::factory()->count(2))
            ->create();

        $this->get(route('discounts.show', $discount))
            ->assertOk()
            ->assertSee($discount->title)
            ->assertSee($discount->precentage)
            ->assertSee($discount->products->first()->name)
            ->assertSee($discount->products->first()->price)
            ->assertSee($discount->products->first()->price_after)
            ->assertSee($discount->products->last()->name)
            ->assertSee($discount->products->last()->price)
            ->assertSee($discount->products->last()->price_after)
            ->assertSee($discount->products->first()->name)
            ->assertSee($discount->products->first()->price)
            ->assertSee($discount->products->first()->price_after)
            ->assertSee($discount->products->last()->name)
            ->assertSee($discount->products->last()->price)
            ->assertSee($discount->products->last()->price_after);
    }
}
