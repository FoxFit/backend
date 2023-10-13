<?php

namespace App\Support;

use App\Contracts\Support\CountryInterface;

use App\Models\CountryChild;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;

class Country implements CountryInterface
{
    /**
     * @var array<string, array<string, mixed>>
     */
    private array $countries;

    /**
     * [
     *      'US' => [
     *          country_state_1,
     *          country_state_2,
     *      ],
     * ].
     * @var array<string, mixed>
     */
    private array $countryStates;

    public function __construct()
    {
        $this->init();
    }

    public function getAllActiveCountries(): array
    {
        return Arr::where($this->countries, function (array $countryData) {
            return $countryData['is_active'];
        });
    }

    public function clearCache(): void
    {
        cache()->clear();
    }

    public function getCountry(?string $countryIso): ?array
    {
        if (!$countryIso) {
            return null;
        }

        if (!array_key_exists($countryIso, $this->countries)) {
            return null;
        }

        return $this->countries[$countryIso];
    }

    public function getCountryName(?string $countryIso): ?string
    {
        if (!$countryIso) {
            return null;
        }

        $country = $this->getCountry($countryIso);

        if (null === $country) {
            return null;
        }

        if (!array_key_exists('name', $country)) {
            return null;
        }

        return $country['name'];
    }

    /**
     * @return array<string, array<string, mixed>>>
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    public function buildCountrySearchForm(): array
    {
        $countries = [['label' => 'All', 'value' => '']];
        $activeCountries = $this->getAllActiveCountries();
        foreach ($activeCountries as $country) {
            $countries[] = [
                'label' => $country['name'],
                'value' => $country['country_iso'],
            ];
        }

        return $countries;
    }

    /**
     * @param ?string $countryIso
     *
     * @return array<string, array<string, mixed>>|null
     */
    public function getCountryStates(?string $countryIso): ?array
    {
        if (!$countryIso || !array_key_exists($countryIso, $this->countryStates)) {
            return null;
        }

        return $this->countryStates[$countryIso];
    }

    protected function init(): void
    {
        $this->countries = \App\Models\Country::query()
            ->get(['name', 'country_iso', 'is_active'])
            ->keyBy('country_iso')
            ->toArray();

        $this->countryStates = CountryChild::query()
            ->get(['name', 'country_iso', 'state_iso'])
            ->keyBy('state_iso')
            ->groupBy('country_iso', true)
            ->toArray();
    }

    public function getCountryStateName(?string $countryIso, ?string $stateIso): ?string
    {
        if (!$countryIso || !$stateIso) {
            return null;
        }

        $states = $this->getCountryStates($countryIso);

        if (null === $states) {
            return null;
        }

        if (!array_key_exists($stateIso, $states)) {
            return null;
        }

        $state = $states[$stateIso];

        if (!array_key_exists('name', $state)) {
            return null;
        }

        return $state['name'];
    }

    public function getDefaultCountryIso(): string
    {
        return 'US';
    }

    /**
     * @throws FileNotFoundException
     */
    public function getDefaultCountryStateIso(): string
    {
        return 'US-AR';
    }
}
