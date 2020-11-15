<?php

namespace Database\Seeders;

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
         \App\Models\Product::factory()->count(10)->create();
        \App\Models\Advertisement::factory()->count(3)->create();
        \App\Models\Order::factory()->count(10)->create();
    }
}
