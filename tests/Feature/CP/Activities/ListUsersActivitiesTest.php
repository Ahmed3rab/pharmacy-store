<?php

namespace Tests\Feature\CP\Activities;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListUsersActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListUserActivities()
    {
        $this->get(route('activities.index'))
            ->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListUserActivities()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->post('/api/activities', [
            'activity' => 'remove_from_cart',
            'uuid'     => $product->uuid,
        ])->assertStatus(201);

        $this->get(route('activities.index'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee(auth()->user()->name);
    }
}
