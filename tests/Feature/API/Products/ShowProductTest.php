<?php

namespace Tests\Feature\API\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guestsCanShowProductDetails()
    {
        $product = Product::factory()->create();

        $this->get("api/products/{$product->uuid}")
            ->assertStatus(200)
            ->assertJson(['data' => [
                'uuid'        => $product->uuid,
                'image_path'  => asset('/storage/' . $product->image_path),
                'name'        => $product->name,
                'position'    => $product->position,
                'description' => $product->description,
                'quantity'    => $product->quantity,
                'price'       => (float) $product->price,
                'price_after' => (float) $product->price_after,
                'discount'    => null,
            ],]);
    }

    /**
     *@test
     */
    function guestsCanShowProductWithDiscountDetails()
    {
        $product = Product::factory()->hasDiscounts(1)->create();

        $this->get("api/products/{$product->uuid}")
            ->assertStatus(200)
            ->assertJson(['data' => [
                'uuid'        => $product->uuid,
                'image_path'  => asset('/storage/' . $product->image_path),
                'name'        => $product->name,
                'position'    => $product->position,
                'description' => $product->description,
                'quantity'    => $product->quantity,
                'price'       => (float) $product->price,
                'price_after' => (float) $product->price_after,
                'discount'    => [
                    'uuid'       => $product->activeDiscount->uuid,
                    'percentage' => (float) $product->activeDiscount->percentage,
                    'starts_at'  => $product->activeDiscount->starts_at->toDateTimeString(),
                    'ends_at'    => $product->activeDiscount->ends_at->toDateTimeString(),
                ],
            ],]);
    }
}
