<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(5),

            'city' => fake()->randomElement([
                'Sydney','Melbourne','Brisbane',
                'Perth','Adelaide'
            ]),

            'suburb' => fake()->streetName(),

            'price' => fake()->numberBetween(50, 500),

            'pricing_type' => fake()->randomElement(['hourly','fixed']),

            'status' => fake()->randomElement([
                \App\Models\Listing::STATUS_APPROVED,
                \App\Models\Listing::STATUS_APPROVED,
                \App\Models\Listing::STATUS_APPROVED,
                \App\Models\Listing::STATUS_PENDING,
                \App\Models\Listing::STATUS_DRAFT,
            ]),
        ];
    }

}
