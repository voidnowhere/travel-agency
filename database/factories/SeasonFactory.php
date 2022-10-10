<?php

namespace Database\Factories;

use App\Enums\SeasonTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date_from = fake()->date(max: '-1 months');
        $date_to = fake()->date();
        if ($date_from > $date_to) {
            $tmp = $date_from;
            $date_from = $date_to;
            $date_to = $tmp;
        }

        return [
            'description' => fake()->sentence(),
            'date_from' => $date_from,
            'date_to' => $date_to,
            'type_SHML' => fake()->randomElement(SeasonTypes::values()),
            'is_active' => fake()->boolean(),
        ];
    }
}
