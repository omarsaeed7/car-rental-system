<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Car::class;
    public function definition(): array
    {


        return [
            'name' => $this->faker->word,
            'type' => $this->faker->word,  // Adjust based on your schema
            'price_per_day' => $this->faker->randomFloat(2, 50, 500),
            'availability_status' => $this->faker->boolean,
        ];
    }
}
