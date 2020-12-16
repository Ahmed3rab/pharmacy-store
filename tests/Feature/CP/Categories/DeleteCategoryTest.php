<?php

namespace Tests\Feature\CP\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotDeleteACategory()
    {
        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertRedirect(route('login'));

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanDeleteACategory()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->get(route('categories.edit', $category))
            ->assertStatus(200)
            ->assertViewIs('categories.edit');

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));

        $this->assertSoftDeleted($category);
    }
}
