<?php

namespace Database\Factories;

use App\Models\Housing;
use App\Models\HousingFormula;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'user_id' => User::factory()->create()->id,
            'housing_id' => Housing::factory()->create()->id,
            'housing_formula_id' => HousingFormula::factory()->create()->id,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'for_count' => fake()->numberBetween(1, 4),
        ];
    }
}
