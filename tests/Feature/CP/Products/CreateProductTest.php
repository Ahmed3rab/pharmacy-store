<?php

namespace Tests\Feature\CP\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateNewProduct()
    {
        $this->get(route('products.create'))
            ->assertRedirect(route('login'));

        $this->post(route('products.store'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewProduct()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('products.create'))
            ->assertStatus(200)
            ->assertViewIs('products.create');

        $this->post(route('products.store'), [
            'name'        => $name        = 'Car Oil',
            'position'    => $position    = 1,
            'description' => $description = 'Car Oils',
            'price'       => $price       = 50,
            'item_price'  => $itemPrice   = 20,
            'quantity'    => $quantity    = 120,
            'category'    => $categoryId  = Category::factory()->create()->id,
            'image'       => $image       = UploadedFile::fake()->image('image.jpg'),
            'published'   => $published   = true,
        ])
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name'        => $name,
            'position'    => $position,
            'description' => $description,
            'price'       => $price,
            'item_price'  => $itemPrice,
            'quantity'    => $quantity,
            'category_id' => $categoryId,
            'published'   => $published,
            'image_path'  => Product::first()->uuid . '-' . time() . '.' . $image->extension(),
        ]);
    }

    /**
     *@test
     */
    function itCreatedUnpublishedProductIfPublishedInputIsNotSet()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('products.store'), [
            'name'        => $name        = 'Car Oil',
            'position'    => $position    = 1,
            'description' => $description = 'Car Oils',
            'price'       => $price       = 50,
            'item_price'  => $itemPrice   = 20,
            'quantity'    => $quantity    = 120,
            'category'    => $categoryId  = Category::factory()->create()->id,
            'image'       => $image       = UploadedFile::fake()->image('image.jpg'),
            // 'published' => ''
        ])
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name'      => $name,
            'published' => false,
        ]);
    }

    /**
     *@test
     */
    function itReturnsValdationMessagesIfRequiredFieldsWereNotSet()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('products.store'), [
            'name'        => '',
            'position'    => '',
            'description' => '',
            'price'       => '',
            'item_price'  => '',
            'quantity'    => '',
            'category'    => '',
            'image'       => '',
        ])
            ->assertSessionHasErrors(['name', 'description', 'price', 'item_price', 'quantity', 'category', 'image']);
    }
}
