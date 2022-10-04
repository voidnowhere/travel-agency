<?php

namespace Database\Factories;

use App\Models\HousingCategory;
use App\Models\Residence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Housing>
 */
class HousingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'residence_id' => Residence::factory()->create()->id,
            'housing_category_id' => HousingCategory::factory()->create()->id,
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
            'for_max' => fake()->numberBetween(1, 4),
            'order_by' => fake()->randomDigitNotZero(),
            'is_active' => fake()->boolean(),
        ];
    }
}
