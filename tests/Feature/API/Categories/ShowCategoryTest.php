<?php

namespace Tests\Feature\API\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guestsCanListCategoryProduct()
    {
        $emptyCategory = Category::factory()->create();

        $this->get("/api/categories/{$emptyCategory->uuid}")
            ->assertStatus(200)
            ->assertJson(['data' => []]);

        $categoryWithProducts = Category::factory()->hasProducts(2)->create();

        $this->get("/api/categories/{$categoryWithProducts->uuid}")
            ->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'uuid'        => $categoryWithProducts->products->first()->uuid,
                    'image_path'  => $categoryWithProducts->products->first()->imagePath(),
                    'name'        => $categoryWithProducts->products->first()->name,
                    'position'    => $categoryWithProducts->products->first()->position,
                    'description' => $categoryWithProducts->products->first()->description,
                    'quantity'    => $categoryWithProducts->products->first()->quantity,
                    'price'       => (float) $categoryWithProducts->products->first()->price,
                    'price_after' => (float) $categoryWithProducts->products->first()->price_after,
                    'discount'    => null,
                ],
                [
                    'uuid'        => $categoryWithProducts->products->last()->uuid,
                    'image_path'  => $categoryWithProducts->products->last()->imagePath(),
                    'name'        => $categoryWithProducts->products->last()->name,
                    'position'    => $categoryWithProducts->products->last()->position,
                    'description' => $categoryWithProducts->products->last()->description,
                    'quantity'    => $categoryWithProducts->products->last()->quantity,
                    'price'       => (float) $categoryWithProducts->products->last()->price,
                    'price_after' => (float) $categoryWithProducts->products->last()->price_after,
                    'discount'    => null,
                ],
            ],]);
    }
}
