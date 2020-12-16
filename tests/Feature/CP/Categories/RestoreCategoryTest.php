<?php

namespace Tests\Feature\CP\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotRestoreACategory()
    {
        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertRedirect(route('login'));

        $this->post(route('categories.restore', $category))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanRestoreACategory()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertStatus(200)
            ->assertViewIs('categories.edit');

        $this->post(route('categories.restore', $category))
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'uuid'       => $category->uuid,
            'deleted_at' => null,
        ]);
    }
}
