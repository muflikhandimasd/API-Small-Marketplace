<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->text(50),
            'product_price' => $this->faker->numberBetween(1000, 10000000),
            'category_id' => $this->faker->numberBetween(1, 10),
            'city' => $this->faker->city(),
            'product_image' => $this->faker->imageUrl(),
            'seller_name' => $this->faker->name(),
        ];
    }
}
