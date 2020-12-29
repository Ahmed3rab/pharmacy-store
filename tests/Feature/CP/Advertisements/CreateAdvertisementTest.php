<?php

namespace Tests\Feature\CP\Advertisements;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateAdvertisementTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    function unauthenticatedUserCanNotCreateAdvertisements()
    {
        $this->get(route('advertisements.create'))->assertRedirect(route('login'));
        $this->post(route('advertisements.store'))->assertRedirect(route('login'));
    }

    /**
     *@test
     */
    function authenticatedUserCanCreateAdvertisements()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('advertisements.create'))->assertOk();
        $this->post(route('advertisements.store'), [
            'title'     => $title = 'Testing Advertisement',
            'url'       => $url = 'http://www.example.com',
            'image'     => $image = UploadedFile::fake()->image('image.jpg'),
            'published' => true,
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('advertisements', [
            'title'     => $title,
            'url'       => $url,
            'published' => true,
        ]);

        Storage::disk('advertisements')->exists(Advertisement::first()->uuid . '-' . time() . '.' . $image->extension());
    }
}
