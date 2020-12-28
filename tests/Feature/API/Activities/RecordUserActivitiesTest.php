<?php

namespace Tests\Feature\API\Activities;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class RecordUserActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function canNotRecordAcivityForUnauthenticatedUser()
    {
        $this->post('/api/activities')->assertStatus(401);
    }

    /**
     *@test
     */
    function recordUsersActivityWhenTheyViewACategory()
    {
        $this->actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $this->post('/api/activities', [
            'activity' => 'view_category',
            'uuid'     => $category->uuid,
        ])->assertStatus(201);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'categories',
            'subject_id'   => $category->id,
            'causer_type'  => 'users',
            'causer_id'    => auth()->id(),
        ]);

        $this->assertEquals('view_category', Activity::first()->getExtraProperty('activity_type'));
    }

    /**
     *@test
     */
    function recordUsersActivityWhenTheyViewAProduct()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->post('/api/activities', [
            'activity' => 'view_product',
            'uuid'     => $product->uuid,
        ])->assertStatus(201);


        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'products',
            'subject_id'   => $product->id,
            'causer_type'  => 'users',
            'causer_id'    => auth()->id(),
        ]);

        $this->assertEquals('view_product', Activity::first()->getExtraProperty('activity_type'));
    }

    /**
     *@test
     */
    function recordUsersActivityWhenTheyAddProductToTheCart()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->post('/api/activities', [
            'activity' => 'add_to_cart',
            'uuid'     => $product->uuid,
        ])->assertStatus(201);


        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'products',
            'subject_id'   => $product->id,
            'causer_type'  => 'users',
            'causer_id'    => auth()->id(),
        ]);

        $this->assertEquals('add_to_cart', Activity::first()->getExtraProperty('activity_type'));
    }

    /**
     *@test
     */
    function recordUsersActivityWhenTheyRemoveAProductToTheCart()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $this->post('/api/activities', [
            'activity' => 'remove_from_cart',
            'uuid'     => $product->uuid,
        ])->assertStatus(201);


        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'products',
            'subject_id'   => $product->id,
            'causer_type'  => 'users',
            'causer_id'    => auth()->id(),
        ]);

        $this->assertEquals('remove_from_cart', Activity::first()->getExtraProperty('activity_type'));
    }
}
