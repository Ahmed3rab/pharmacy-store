<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateDiscountTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateDiscount()
    {
        $discount = Discount::factory()->create();

        $this->get(route('discounts.edit', $discount))->assertRedirect(route('login'));
        $this->patch(route('discounts.update', $discount))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateDiscountToSpecificCategories()
    {
        $this->actingAs(User::factory()->create());

        $oldDiscount = Discount::factory()->create();
        $newDiscount = Discount::factory()->make();
        $categories = Category::factory()->times(2)->hasProducts()->create();

        $this->get(route('discounts.edit', $oldDiscount))->assertOk();
        $this->patch(route('discounts.update', $oldDiscount), array_merge($newDiscount->toArray(), [
            'categories' => $categories->map->only('uuid')->toArray(),
        ]))
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('discounts', $newDiscount->makeHidden(['uuid', 'starts_at', 'ends_at'])->toArray());

        $this->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $categories->first()->id,
        ])->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'categories',
            'discountable_id'   => $categories->last()->id,
        ]);

        $this->assertEquals(($categories->first()->products->first()->price - ($newDiscount->percentage * $categories->first()->products->first()->price / 100)),
            $categories->first()->products->first()->price_after
        );
        $this->assertEquals(($categories->first()->products->last()->price - ($newDiscount->percentage * $categories->first()->products->last()->price / 100)),
            $categories->first()->products->last()->price_after
        );

        $this->assertEquals(($categories->last()->products->first()->price - ($newDiscount->percentage * $categories->last()->products->first()->price / 100)),
            $categories->last()->products->first()->price_after
        );
        $this->assertEquals(($categories->last()->products->last()->price - ($newDiscount->percentage * $categories->last()->products->last()->price / 100)),
            $categories->last()->products->last()->price_after
        );
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateDiscountToSpecificProducts()
    {
        $this->actingAs(User::factory()->create());

        $oldDiscount = Discount::factory()->create();
        $newDiscount = Discount::factory()->make();
        $products = Product::factory()->times(2)->create();

        $this->get(route('discounts.edit', $oldDiscount))->assertOk();
        $this->patch(route('discounts.update', $oldDiscount), array_merge($newDiscount->toArray(), [
            'products' => $products->map->only('uuid')->toArray(),
        ]))
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('discounts', $newDiscount->makeHidden(['uuid', 'starts_at', 'ends_at'])->toArray());

        $this->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'products',
            'discountable_id'   => $products->first()->id,
        ])->assertDatabaseHas('discountables', [
            'discount_id'       => Discount::first()->id,
            'discountable_type' => 'products',
            'discountable_id'   => $products->last()->id,
        ]);

        $this->assertEquals(($products->first()->price - ($newDiscount->percentage * $products->first()->price / 100)), $products->first()->price_after);
        $this->assertEquals(($products->last()->price - ($newDiscount->percentage * $products->last()->price / 100)), $products->last()->price_after);
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateDiscountCoverImage()
    {
        Storage::fake();

        $this->actingAs(User::factory()->create());

        $oldDiscount = Discount::factory()->create();
        $newDiscount = Discount::factory()->make();
        $products = Product::factory()->times(2)->create();

        $this->get(route('discounts.edit', $oldDiscount))->assertOk();
        $this->patch(route('discounts.update', $oldDiscount), array_merge($newDiscount->toArray(), [
            'products'    => $products->map->only('uuid')->toArray(),
            'cover_image' => $image = UploadedFile::fake()->image('image.jpg'),
        ]))
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('discounts', [
            'title'            => $newDiscount->title,
            'cover_image_path' => $oldDiscount->uuid . '-' . time() . '.' . $image->extension(),
        ]);

        Storage::disk('discounts')->exists(Discount::first()->uuid . '-' . time() . '.' . $image->extension());
    }
}
