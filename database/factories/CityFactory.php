<?php

namespace Database\Factories;

use App\Models\Country;
use App\Traits\FactoryActiveStatusTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
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
            'country_id' => Country::factory()->create()->id,
            'name' => fake()->unique()->city(),
            'order_by' => fake()->randomDigitNotZero(),
            'is_active' => fake()->boolean(),
        ];
    }
}
