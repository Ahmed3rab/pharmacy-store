<?php

namespace Database\Factories;

use App\Models\ProductDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid'       => $this->faker->uuid,
            'title'      => $this->faker->sentence,
            'percentage' => $this->faker->numberBetween(10, 90),
            'starts_at'  => $this->faker->dateTimeBetween('-10days', 'now'),
            'ends_at'    => $this->faker->dateTimeBetween('now', '+20days'),
        ];
    }
}
