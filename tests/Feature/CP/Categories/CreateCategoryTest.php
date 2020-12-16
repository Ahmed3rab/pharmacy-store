<?php

namespace Tests\Feature\CP\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateNewCategory()
    {
        $this->get(route('categories.create'))
            ->assertRedirect(route('login'));

        $this->post(route('categories.store'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateNewCategory()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('categories.create'))
            ->assertStatus(200)
            ->assertViewIs('categories.create');

        $this->post(route('categories.store'), [
            'name'      => 'Car Oil',
            'position'  => 1,
            'icon'      => $icon = UploadedFile::fake()->image('icon.jpg'),
            'published' => true,
        ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name'      => 'Car Oil',
            'position'  => 1,
            'published' => true,
            'icon_path' => Category::first()->uuid . '-' . time() . '.' . $icon->extension(),
        ]);
    }

    /**
     *@test
     */
    function itCreatedUnpublishedCategoryIfPublishedInputIsNotSet()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('categories.store'), [
            'name'      => 'Car Oil',
            'position'  => 1,
            'icon'      => $icon = UploadedFile::fake()->image('icon.jpg'),
        ])
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name'      => 'Car Oil',
            'published' => false,
        ]);
    }

    /**
     *@test
     */
    function itReturnsValdationMessagesIfRequiredFieldsWereNotSet()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('categories.store'), [
            'name'      => '',
            'icon'      => null,
        ])
            ->assertSessionHasErrors(['name', 'icon']);
    }
}
