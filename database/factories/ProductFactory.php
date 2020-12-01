<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'image_path'  => $this->faker->imageUrl(),
            'name'        => $this->faker->name,
            'description' => $this->faker->paragraph,
            'price'       => $this->faker->randomNumber(3),
            'quantity'    => $this->faker->randomNumber(2),
        ];
    }
}
