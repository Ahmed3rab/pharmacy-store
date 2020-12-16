<?php

namespace Tests\Feature\CP\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateProduct()
    {
        $product = Product::factory()->create();

        $this->get(route('products.edit', $product))
            ->assertRedirect(route('login'));

        $this->patch(route('products.update', $product))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateProduct()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->get(route('products.edit',  $product))
            ->assertStatus(200)
            ->assertViewIs('products.edit');

        $this->patch(route('products.update',  $product), [
            'name'        => $name = 'Car Oil',
            'position'    => $position = 1,
            'description' => $description = 'Car Oils',
            'price'       => $price = 50,
            'quantity'    => $quantity = 120,
            'category'    => $categoryId = Category::factory()->create()->id,
            'image'       => $image = UploadedFile::fake()->image('image.jpg'),
            'published'   => $published = true,
        ]);

        $this->assertDatabaseHas('products', [
            'uuid'        => $product->uuid,
            'name'        => $name,
            'position'    => $position,
            'description' => $description,
            'price'       => $price,
            'quantity'    => $quantity,
            'category_id' => $categoryId,
            'published'   => $published,
            'image_path'  => Product::first()->uuid . '-' . time() . '.' . $image->extension(),
        ]);
    }
}
