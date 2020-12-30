<?php

namespace Tests\Feature\API\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListDiscountsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guestsCanListDiscounts()
    {
        $categoriesDiscount = Discount::factory()
            ->hasAttached(Category::factory()->times(2)->hasProducts(1))
            ->create();

        $productsDiscount = Discount::factory()
            ->hasAttached(Product::factory()->count(2))
            ->create();

        $this->get('api/discounts')
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'uuid'             => $categoriesDiscount->uuid,
                        'title'             => $categoriesDiscount->title,
                        'percentage'       => (float) $categoriesDiscount->percentage,
                        'starts_at'        => $categoriesDiscount->starts_at->toDateTimeString(),
                        'ends_at'          => $categoriesDiscount->ends_at->toDateTimeString(),
                        'featured'         => $categoriesDiscount->featured,
                        'cover_image_path' => $categoriesDiscount->coverImagePath(),
                    ],
                    [
                        'uuid'             => $productsDiscount->uuid,
                        'title'            => $productsDiscount->title,
                        'percentage'       => (float) $productsDiscount->percentage,
                        'starts_at'        => $productsDiscount->starts_at->toDateTimeString(),
                        'ends_at'          => $productsDiscount->ends_at->toDateTimeString(),
                        'featured'         => $productsDiscount->featured,
                        'cover_image_path' => $productsDiscount->coverImagePath(),
                    ],
                ],
            ]);
    }

    /**
     *@test
     */
    function guestsCanListFeaturedDiscountsOnly()
    {
        $featuredDiscount = Discount::factory()->create(['featured' => true]);

        $unfeaturedDiscount = Discount::factory()->create(['featured' => false]);

        $this->get('api/discounts?featured=true')
            ->assertOk()
            ->assertSee($featuredDiscount->title)
            ->assertDontSee($unfeaturedDiscount->title);
    }
}
