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
                        'uuid'       => $categoriesDiscount->uuid,
                        'percentage' => (float) $categoriesDiscount->percentage,
                        'starts_at'  => $categoriesDiscount->starts_at->toDateTimeString(),
                        'ends_at'    => $categoriesDiscount->ends_at->toDateTimeString(),
                        'products'   => [],
                        'categories' => [
                            [
                                'uuid'      => $categoriesDiscount->categories->first()->uuid,
                                'icon_path' => $categoriesDiscount->categories->first()->iconPath(),
                                'position'  => (int) $categoriesDiscount->categories->first()->position,
                                'name'      => $categoriesDiscount->categories->first()->name,
                                'products'  => [
                                    [
                                        'uuid'        => $categoriesDiscount->categories->first()->products->first()->uuid,
                                        'image_path'  => $categoriesDiscount->categories->first()->products->first()->imagePath(),
                                        'name'        => $categoriesDiscount->categories->first()->products->first()->name,
                                        'position'    => $categoriesDiscount->categories->first()->products->first()->position,
                                        'description' => $categoriesDiscount->categories->first()->products->first()->description,
                                        'quantity'    => $categoriesDiscount->categories->first()->products->first()->quantity,
                                        'item_price'  => (float) $categoriesDiscount->categories->first()->products->first()->item_price,
                                        'price'       => (float) $categoriesDiscount->categories->first()->products->first()->price,
                                        'price_after' => (float) $categoriesDiscount->categories->first()->products->first()->price_after,
                                    ],
                                ],
                            ],
                            [
                                'uuid'      => $categoriesDiscount->categories->last()->uuid,
                                'icon_path' => $categoriesDiscount->categories->last()->iconPath(),
                                'position'  => (int) $categoriesDiscount->categories->last()->position,
                                'name'      => $categoriesDiscount->categories->last()->name,
                                'products'  => [
                                    [
                                        'uuid'        => $categoriesDiscount->categories->last()->products->first()->uuid,
                                        'image_path'  => $categoriesDiscount->categories->last()->products->first()->imagePath(),
                                        'name'        => $categoriesDiscount->categories->last()->products->first()->name,
                                        'position'    => $categoriesDiscount->categories->last()->products->first()->position,
                                        'description' => $categoriesDiscount->categories->last()->products->first()->description,
                                        'quantity'    => $categoriesDiscount->categories->last()->products->first()->quantity,
                                        'item_price'  => (float) $categoriesDiscount->categories->last()->products->first()->item_price,
                                        'price'       => (float) $categoriesDiscount->categories->last()->products->first()->price,
                                        'price_after' => (float) $categoriesDiscount->categories->last()->products->first()->price_after,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'uuid'       => $productsDiscount->uuid,
                        'percentage' => (float) $productsDiscount->percentage,
                        'starts_at'  => $productsDiscount->starts_at->toDateTimeString(),
                        'ends_at'    => $productsDiscount->ends_at->toDateTimeString(),
                        "categories" => [],
                        'products'   => [
                            [
                                'uuid'        => $productsDiscount->products->first()->uuid,
                                'image_path'  => $productsDiscount->products->first()->imagePath(),
                                'name'        => $productsDiscount->products->first()->name,
                                'position'    => $productsDiscount->products->first()->position,
                                'description' => $productsDiscount->products->first()->description,
                                'quantity'    => $productsDiscount->products->first()->quantity,
                                'item_price'  => (float) $productsDiscount->products->first()->item_price,
                                'price'       => (float) $productsDiscount->products->first()->price,
                                'price_after' => (float) $productsDiscount->products->first()->price_after,
                            ],
                            [
                                'uuid'        => $productsDiscount->products->last()->uuid,
                                'image_path'  => $productsDiscount->products->last()->imagePath(),
                                'name'        => $productsDiscount->products->last()->name,
                                'position'    => $productsDiscount->products->last()->position,
                                'description' => $productsDiscount->products->last()->description,
                                'quantity'    => $productsDiscount->products->last()->quantity,
                                'item_price'  => (float) $productsDiscount->products->last()->item_price,
                                'price'       => (float) $productsDiscount->products->last()->price,
                                'price_after' => (float) $productsDiscount->products->last()->price_after,
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
