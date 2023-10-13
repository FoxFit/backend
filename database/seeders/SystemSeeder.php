<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryChild;
use App\Models\CountryCity;
use Illuminate\Database\Seeder;
use MenaraSolutions\Geographer\City;
use MenaraSolutions\Geographer\Earth;
use MenaraSolutions\Geographer\State;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCountry();
    }

    private function seedCountry(): void
    {
        $checkExist = Country::query()->first();
        if (null != $checkExist) {
            return;
        }

        $countries = (new Earth())->getCountries();
        $insertCountries = [];
        $insertStates = [];
        $insertCities = [];

        /** @var \MenaraSolutions\Geographer\Country $country */
        foreach ($countries as $country) {
            $countryData = $country->toArray();

            $insertCountries[] = [
                'code'            => $countryData['code'],
                'code3'           => $countryData['code3'],
                'country_iso'     => $countryData['isoCode'],
                'numeric_code'    => $countryData['numericCode'],
                'geonames_code'   => $countryData['geonamesCode'],
                'fips_code'       => $countryData['fipsCode'],
                'area'            => $countryData['area'],
                'currency'        => $countryData['currency'],
                'phone_prefix'    => $countryData['phonePrefix'],
                'mobile_format'   => $countryData['mobileFormat'],
                'landline_format' => $countryData['landlineFormat'],
                'trunk_prefix'    => $countryData['trunkPrefix'],
                'population'      => $countryData['population'],
                'continent'       => $countryData['continent'],
                'language'        => $countryData['language'],
                'name'            => $countryData['name'],
            ];

            $states = $country->getStates();

            /** @var State $state */
            foreach ($states as $state) {
                $stateData = $state->toArray();

                $insertStates[] = [
                    'country_iso'   => $state->getParentCode(),
                    'state_iso'     => $stateData['isoCode'],
                    'state_code'    => $stateData['code'],
                    'fips_code'     => $stateData['fipsCode'],
                    'geonames_code' => $stateData['geonamesCode'],
                    'post_codes'    => json_encode($stateData['postCodes']),
                    'name'          => $stateData['name'],
                    'timezone'      => $stateData['timezone'],
                ];

                $cities = $state->getCities();

                /** @var City $city */
                foreach ($cities as $city) {
                    $cityData = $city->toArray();

                    $insertCities[] = [
                        'state_code'    => $city->getParentCode(),
                        'city_code'     => $cityData['code'],
                        'geonames_code' => $cityData['geonamesCode'],
                        'name'          => $cityData['name'],
                        'latitude'      => $cityData['latitude'],
                        'longitude'     => $cityData['longitude'],
                        'population'    => $cityData['population'],
                        'capital'       => $cityData['capital'],
                    ];
                }
            }

            // release memory ASAP for a large data set
            if (count($insertStates) > 1000) {
                $this->seedStates($insertStates);
            }

            if (count($insertCities) > 1000) {
                $this->seedCities($insertCities);
            }
        }

        Country::query()->insertOrIgnore($insertCountries);
        $this->seedStates($insertStates);
        $this->seedCities($insertCities);

    }

    /**
     * @param array<mixed> $insertCities
     */
    private function seedCities(array &$insertCities)
    {
        do {
            CountryCity::query()
                ->insertOrIgnore(array_splice($insertCities, 0, 200));
        } while (!empty($insertCities));
    }

    /**
     * @param array<mixed> $insertStates
     */
    private function seedStates(array &$insertStates)
    {
        do {
            CountryChild::query()
                ->insertOrIgnore(array_splice($insertStates, 0, 200));
        } while (!empty($insertStates));
    }
}
