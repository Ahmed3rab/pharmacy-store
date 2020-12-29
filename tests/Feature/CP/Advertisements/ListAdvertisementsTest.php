<?php

namespace Tests\Feature\CP\Advertisements;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListAdvertisementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotListAdvertisements()
    {
        $this->get(route('advertisements.index'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanListAdvertisements()
    {
        $this->actingAs(User::factory()->create());

        $advertisements = Advertisement::factory()->times(2)->create();

        $this->get(route('advertisements.index'))
            ->assertOk()
            ->assertSee($advertisements->first()->title)
            ->assertSee($advertisements->last()->title);
    }
}
