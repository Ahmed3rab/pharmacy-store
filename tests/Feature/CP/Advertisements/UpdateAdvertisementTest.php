<?php

namespace Tests\Feature\CP\Advertisements;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateAdvertisementTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotUpdateAnAdvertisement()
    {
        $advertisement = Advertisement::factory()->create();

        $this->get(route('advertisements.edit', $advertisement))->assertRedirect(route('login'));
        $this->patch(route('advertisements.update', $advertisement))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanUpdateAnAdvertisement()
    {
        $this->actingAs(User::factory()->create());
        $advertisement = Advertisement::factory()->create();

        $this->get(route('advertisements.edit', $advertisement))->assertOk();
        $this->patch(route('advertisements.update', $advertisement), [
            'title'     => $title = 'Testing Advertisement',
            'url'       => $url = 'http://www.example.com',
            'image'     => $image = UploadedFile::fake()->image('image.jpg'),
            'published' => true,
        ])
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('advertisements', [
            'title'     => $title,
            'url'       => $url,
            'published' => true,
        ]);

        Storage::disk('advertisements')->exists(Advertisement::first()->uuid . '-' . time() . '.' . $image->extension());
    }
}
