<?php

namespace Database\Factories;

use App\Enums\SeasonTypes;
use App\Models\Housing;
use App\Models\HousingFormula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HousingPrice>
 */
class HousingPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'housing_id' => Housing::factory()->create()->id,
            'housing_formula_id' => HousingFormula::factory()->create()->id,
            'type_SHML' => fake()->randomElement(SeasonTypes::values()),
            'for_one_price' => fake()->randomFloat(),
            'extra_price' => fake()->randomFloat(),
            'extra_price_is_active' => fake()->boolean(),
            'min_nights' => fake()->numberBetween(1),
            'weekends' => '0,6',
            'weekend_price' => fake()->randomFloat(),
            'weekend_is_active' => fake()->boolean(),
            'kid_bed_price' => fake()->randomFloat(),
            'kid_bed_is_active' => fake()->boolean(),
            'extra_bed_price' => fake()->randomFloat(),
            'extra_bed_is_active' => fake()->boolean(),
        ];
    }
}
