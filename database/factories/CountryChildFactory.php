<?php

namespace Database\Factories;

use App\Models\CountryChild;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryChildFactory.
 * @method CountryChild create($attributes = [], ?Model $parent = null)
 */
class CountryChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CountryChild::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_iso' => $this->faker->regexify('[a-zA-Z]{1}[0-9]{1}'),
            'name'        => $this->faker->city,
            'ordering'    => $this->faker->numberBetween(1, 100),
        ];
    }
}
