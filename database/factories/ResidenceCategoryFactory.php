<?php

namespace Database\Factories;

use App\Traits\FactoryActiveStatusTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResidenceCategory>
 */
class ResidenceCategoryFactory extends Factory
{
    use FactoryActiveStatusTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->word(),
            'order_by' => fake()->randomDigitNotZero(),
            'is_active' => fake()->boolean(),
        ];
    }
}
