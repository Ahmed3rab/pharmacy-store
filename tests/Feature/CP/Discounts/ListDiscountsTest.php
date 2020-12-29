<?php

namespace Tests\Feature\CP\Discounts;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListDiscountsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListDiscounts()
    {
        $this->get(route('discounts.index'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListDiscounts()
    {
        $this->actingAs(User::factory()->create());

        $discounts = Discount::factory()->times(2)->create();

        $this->get(route('discounts.index'))
            ->assertOk()
            ->assertSee($discounts->first()->title)
            ->assertSee($discounts->first()->precentage)
            ->assertSee($discounts->last()->title)
            ->assertSee($discounts->last()->precentage);
    }
}
