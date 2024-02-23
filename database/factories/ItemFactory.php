<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 1000), // Generates a float between 1 and 1000
            'category_id' => $this->faker->numberBetween(1, 10), // Adjust the range according to your category IDs
            'image' => null, // Assuming handling of image upload is done elsewhere
        ];
    }
}
