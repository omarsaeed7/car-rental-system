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
        $carNames = [
            'Ford Focus',
            'Chevrolet Camaro',
            'Toyota Corolla',
            'Honda Civic',
            'BMW X5',
            'Mercedes-Benz A-Class',
            'Audi Q7',
            'Nissan Altima',
            'Hyundai Sonata',
            'Tesla Model 3',
            'Jeep Wrangler',
            'Volkswagen Golf'
        ];

        $carTypes = [
            'Sedan',
            'SUV',
            'Coupe',
            'Convertible',
            'Hatchback',
            'Truck',
            'Minivan',
            'Station Wagon',
            'Sports Car',
            'Luxury'
        ];

        return [
            'name' => $this->faker->randomElement($carNames),
            'type' => $this->faker->randomElement($carTypes),  // Adjust based on your schema
            'price_per_day' => $this->faker->randomFloat(2, 50, 1000),
            'availability_status' => $this->faker->boolean,
        ];
    }
}
