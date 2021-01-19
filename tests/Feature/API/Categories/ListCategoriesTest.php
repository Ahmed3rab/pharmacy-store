<?php

namespace Tests\Feature\API\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestsCanListPublishedCategories()
    {
        $category = Category::factory()->create();
        $categoryWithDiscount = Category::factory()->hasDiscounts(1)->create();
        $unpublishedCategory = Category::factory()->create(['published' => false]);

        $this->get("/api/categories")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'uuid'      => $category->uuid,
                        'icon_path' => $category->iconPath(),
                        'position'  => $category->position,
                        'name'      => $category->name,
                        'discount'  => null,
                    ],
                    [
                        'uuid'      => $categoryWithDiscount->uuid,
                        'icon_path' => $categoryWithDiscount->iconPath(),
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
            ])
            ->assertDontSee($unpublishedCategory->uuid)
            ->assertDontSee($unpublishedCategory->name);
    }

    /**
    * @test
    */
    public function guestsCanListParentCategories()
    {
        Category::factory()->has(Category::factory()->count(2), 'subCategories')->count(4)->create();
        $subCategory = Category::whereNotNull('parent_id')->first();
        $response = $this->get('/api/categories');
        $response->assertJsonCount(4, 'data')->assertJsonMissing($subCategory->toArray());
    }
}
