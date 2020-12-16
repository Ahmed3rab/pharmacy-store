<?php

namespace Tests\Feature\CP\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateNewCategory()
    {
        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertRedirect(route('login'));

        $this->patch(route('categories.update', $category))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateACategory()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertStatus(200)
            ->assertViewIs('categories.edit');

        $this->patch(route('categories.update', $category), [
            'name'      => 'Car Oil',
            'position'  => 1,
            'icon'      => $icon = UploadedFile::fake()->image('icon.jpg'),
            'published' => true,
        ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'uuid'      => $category->uuid,
            'name'      => 'Car Oil',
            'position'  => 1,
            'published' => true,
            'icon_path' => Category::first()->uuid . '-' . time() . '.' . $icon->extension(),
        ]);
    }
}
