<?php

namespace Tests\Feature\CP\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListCategories()
    {
        $this->get(route('categories.index'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUsersCanListCategories()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->get(route('categories.index'))
            ->assertStatus(200)
            ->assertViewIs('categories.index')
            ->assertSee($category->name)
            ->assertSee($category->position)
            ->assertSee($category->products->count());
    }
}
