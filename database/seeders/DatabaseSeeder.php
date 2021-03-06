<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDiscountItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'email' => 'info@example.com',
            'password' => bcrypt('111111'),
        ]);

        \App\Models\User::factory()->create([
            'phone_number' => '0920000000'
        ]);

        Category::factory()->has(Category::factory()->count(3)->hasProducts(10), 'subCategories')->count(5)->create();
        // Category::factory()->times(1)->hasProducts(30)->create();
        // Category::factory()->times(5)->hasDiscounts(1)->hasProducts(6)->create();

        // Product::factory()
        //     ->count(10)
        //     ->for(Category::factory()->count(10)->for(Category::factory()->count(5)->create())->create())
        //     ->hasDiscounts(1)
        //     ->create();

        // ProductDiscountItem::factory()->times(5)->create();

        \App\Models\Advertisement::factory()->count(3)->create();
        \App\Models\Order::factory()->count(10)->create();
    }
}
