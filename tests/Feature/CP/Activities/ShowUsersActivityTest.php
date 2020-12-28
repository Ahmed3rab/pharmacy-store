<?php

namespace Tests\Feature\CP\Activities;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ShowUsersActivityTest extends TestCase
{
    use RefreshDatabase;

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

        $this->get(route('activities.show', Activity::first()))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee(auth()->user()->name);
    }
}
