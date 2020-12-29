<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateNewDiscount()
    {
        $this->get(route('discounts.create'))->assertRedirect(route('login'));
        $this->post(route('discounts.store'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewDiscountToSpecificCategories()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()->make();
        $categories = Category::factory()->times(2)->hasProducts()->create();

        $this->get(route('discounts.create'))->assertOk();
        $this->post(route('discounts.store'), array_merge($discount->toArray(), [
            'categories' => $categories->map->only('uuid')->toArray(),
        ]))
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('discounts', $discount->makeHidden(['uuid', 'starts_at', 'ends_at'])->toArray());

        $this->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $categories->first()->id,
        ])->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $categories->last()->id,
        ]);

        $this->assertEquals(($categories->first()->products->first()->price - ($discount->percentage * $categories->first()->products->first()->price / 100)),
            $categories->first()->products->first()->price_after
        );
        $this->assertEquals(($categories->first()->products->last()->price - ($discount->percentage * $categories->first()->products->last()->price / 100)),
            $categories->first()->products->last()->price_after
        );

        $this->assertEquals(($categories->last()->products->first()->price - ($discount->percentage * $categories->last()->products->first()->price / 100)),
            $categories->last()->products->first()->price_after
        );
        $this->assertEquals(($categories->last()->products->last()->price - ($discount->percentage * $categories->last()->products->last()->price / 100)),
            $categories->last()->products->last()->price_after
        );
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewDiscountToSpecificProducts()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()->make();
        $products = Product::factory()->times(2)->create();

        $this->get(route('discounts.create'))->assertOk();
        $this->post(route('discounts.store'), array_merge($discount->toArray(), [
            'products' => $products->map->only('uuid')->toArray(),
        ]))
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('discounts', $discount->makeHidden(['uuid', 'starts_at', 'ends_at'])->toArray());

        $this->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'products',
            'discountable_id'   => $products->first()->id,
        ])->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'products',
            'discountable_id'   => $products->last()->id,
        ]);

        $this->assertEquals(($products->first()->price - ($discount->percentage * $products->first()->price / 100)), $products->first()->price_after);
        $this->assertEquals(($products->last()->price - ($discount->percentage * $products->last()->price / 100)), $products->last()->price_after);
    }
}
