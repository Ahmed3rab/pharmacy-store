<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function has_parent_scope()
    {
        Category::factory()->has(Category::factory()->count(10), 'subCategories')->count(3)->create();
        $this->assertCount(3, Category::parent()->get());
    }
}
