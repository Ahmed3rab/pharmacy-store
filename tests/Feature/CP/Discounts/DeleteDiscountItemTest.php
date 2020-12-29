<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDiscountItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function authenticatedUserCanDeleteDiscountItem()
    {
        $this->actingAs(User::factory()->create());

        $discount = Discount::factory()->hasAttached(Category::factory())->create();
        $category = $discount->categories->first();

        $this->delete(route('discounts-items.destroy', ['discount' => $discount, 'item' => $discount->items->first()->id]));

        $this->assertDatabaseMissing('discountables', [
            'discount_id'       => $discount->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $category->id,
        ]);
    }
}
