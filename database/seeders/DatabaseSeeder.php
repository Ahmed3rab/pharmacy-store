<?php

namespace Database\Seeders;

use App\Models\Category;
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

        Category::factory()->times(1)->hasProducts(30)->create();
        Category::factory()->times(5)->hasProducts(6)->create();

        \App\Models\Advertisement::factory()->count(3)->create();
        \App\Models\Order::factory()->count(10)->create();
    }
}
