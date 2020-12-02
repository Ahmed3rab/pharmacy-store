<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\ProductDiscountItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDiscountItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDiscountItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_discount_id' => $discount = ProductDiscount::factory()->create(),
            'product_id'          => $product = Product::factory()->create(),
            'price_after'         => $discount->getSalePriceOfProduct($product),
        ];
    }
}
