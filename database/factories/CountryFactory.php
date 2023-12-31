<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryFactory.
 * @method Country create($attributes = [], ?Model $parent = null)
 */
class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_iso' => $this->faker->regexify('[a-zA-Z]{1}[0-9]{1}'),
            'name'        => $this->faker->country,
            'is_active'   => $this->faker->numberBetween(0, 1),
            'ordering'    => $this->faker->numberBetween(1, 100),
        ];
    }
}
