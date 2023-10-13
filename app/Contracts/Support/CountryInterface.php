<?php

namespace App\Contracts\Support;

interface CountryInterface
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public function getAllActiveCountries(): array;

    public function clearCache(): void;

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getCountries(): array;

    /**
     * @param ?string $countryIso
     *
     * @return array<string, mixed>|null
     */
    public function getCountry(?string $countryIso): ?array;

    public function getCountryName(?string $countryIso): ?string;

    /**
     * @return array<int, mixed>
     */
    public function buildCountrySearchForm(): array;

    /**
     * @param ?string $countryIso
     *
     * @return array<string, array<string, mixed>>|null
     */
    public function getCountryStates(?string $countryIso): ?array;

    /**
     * @param string|null $countryIso
     * @param string|null $stateIso
     *
     * @return string|null
     */
    public function getCountryStateName(?string $countryIso, ?string $stateIso): ?string;

    public function getDefaultCountryIso(): string;

    public function getDefaultCountryStateIso(): string;
}
