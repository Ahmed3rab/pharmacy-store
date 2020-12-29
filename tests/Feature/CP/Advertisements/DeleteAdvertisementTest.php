<?php

namespace Tests\Feature\CP\Advertisements;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAdvertisementTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateAnAdvertisement()
    {
        $advertisement = Advertisement::factory()->create();

        $this->get(route('advertisements.edit', $advertisement))->assertRedirect(route('login'));
        $this->delete(route('advertisements.destroy', $advertisement))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateAnAdvertisement()
    {
        $this->actingAs(User::factory()->create());
        $advertisement = Advertisement::factory()->create();

        $this->get(route('advertisements.edit', $advertisement))->assertOk();
        $this->delete(route('advertisements.update', $advertisement))
            ->assertRedirect(route('advertisements.index'));
    }
}
