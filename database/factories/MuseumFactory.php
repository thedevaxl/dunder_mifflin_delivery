<?php

namespace Database\Factories;

use App\Models\Museum;
use Illuminate\Database\Eloquent\Factories\Factory;

class MuseumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Museum::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Museum',
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'region' => $this->faker->state,
            'province' => $this->faker->stateAbbr,
            'municipality' => $this->faker->city,
        ];
    }
}
