<?php

namespace Tests\Feature\API\Categories;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guestsCanListCategories()
    {
        $category = Category::factory()->create();
        $categoryWithDiscount = Category::factory()->hasDiscounts(1)->create();

        $this->get("/api/categories")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid'      => $category->uuid,
                        'icon_path' => $category->icon_path,
                        'position'  => $category->position,
                        'name'      => $category->name,
                        'discount'  => null,
                    ],
                    [
                        'uuid'      => $categoryWithDiscount->uuid,
                        'icon_path' => $categoryWithDiscount->icon_path,
                        'position'  => $categoryWithDiscount->position,
                        'name'      => $categoryWithDiscount->name,
                        'discount'  => [
                            'uuid'        => $categoryWithDiscount->activeDiscount->uuid,
                            'percentage'  => (float) $categoryWithDiscount->activeDiscount->percentage,
                            'starts_at'   => $categoryWithDiscount->activeDiscount->starts_at->toDateTimeString(),
                            'ends_at'     => $categoryWithDiscount->activeDiscount->ends_at->toDateTimeString(),
                        ],
                    ],
                ],
            ]);
    }
}
