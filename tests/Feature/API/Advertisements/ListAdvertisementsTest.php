<?php

namespace Tests\Feature\API\Advertisements;

use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListAdvertisementsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function guestsCanListAdvertisements()
    {
        $advertisements = Advertisement::factory()->times(2)->create();

        $this->get('/api/advertisements')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'image_path' => $advertisements->first()->imagePath(),
                        'title'      => $advertisements->first()->title,
                        'url'        => $advertisements->first()->url,
                    ],
                    [
                        'image_path' => $advertisements->last()->imagePath(),
                        'title'      => $advertisements->last()->title,
                        'url'        => $advertisements->last()->url,
                    ],
                ],
            ]);
    }
}
