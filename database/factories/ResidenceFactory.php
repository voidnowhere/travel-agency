<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\ResidenceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Residence>
 */
class ResidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city_id' => City::factory()->create()->id,
            'residence_category_id' => ResidenceCategory::factory()->create()->id,
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'website' => fake()->url(),
            'email' => fake()->freeEmail(),
            'contact' => fake()->firstName(),
            'tax' => fake()->randomFloat(),
            'order_by' => fake()->randomDigitNotZero(),
            'is_active' => fake()->boolean(),
        ];
    }
}
