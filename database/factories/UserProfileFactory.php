<?php

namespace Database\Factories;

use App\Models\UserProfile;
use App\Support\Facades\Country;
use App\Support\Facades\CountryCity;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public $model = UserProfile::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number'      => $this->faker->phoneNumber,
            'full_phone_number' => $this->faker->phoneNumber,
            'gender'            => rand(1, 2),
            'city_location'     => $this->faker->address,
            'country_iso'       => Country::getDefaultCountryIso(),
            'country_state_id'  => Country::getDefaultCountryStateIso(),
            'country_city_code' => CountryCity::getDefaultCityCode(),
            'postal_code'       => 1,
            'birthday'          => $this->faker->date(),
            'avatar_path'       => faker_image_path('avatar/256x256'),
        ];
    }
}
