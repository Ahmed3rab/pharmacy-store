<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotDeleteADiscount()
    {
        $discount = Discount::factory()->create();

        $this->get(route('discounts.edit', $discount))->assertRedirect(route('login'));
        $this->delete(route('discounts.destroy', $discount))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteADiscountAndItsAttachedCategories()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()->hasAttached(Category::factory()->hasProducts(1)->count(2))->create();
        $categories = $discount->categories;

        $this->get(route('discounts.edit', $discount))->assertOk();
        $this->delete(route('discounts.destroy', $discount))
            ->assertRedirect(route('discounts.index'));

        $this->assertDeleted($discount);
        $this->assertDatabaseMissing('discountables', [
            'discount_id'       => $discount->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $categories->first()->id,
        ])
            ->assertDatabaseMissing('discountables', [
                'discount_id'       => $discount->id,
                'discountable_type' => 'categories',
                'discountable_id'   => $categories->last()->id,
            ]);
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteADiscountAndItsAttachedProducts()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()->hasAttached(Product::factory()->count(2))->create();
        $products = $discount->products;

        $this->get(route('discounts.edit', $discount))->assertOk();
        $this->delete(route('discounts.destroy', $discount))
            ->assertRedirect(route('discounts.index'));

        $this->assertDeleted($discount);
        $this->assertDatabaseMissing('discountables', [
            'discount_id'       => $discount->id,
            'discountable_type' => 'products',
            'discountable_id'   => $products->first()->id,
        ])
            ->assertDatabaseMissing('discountables', [
                'discount_id'       => $discount->id,
                'discountable_type' => 'products',
                'discountable_id'   => $products->last()->id,
            ]);
    }
}
