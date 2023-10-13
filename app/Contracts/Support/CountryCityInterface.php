<?php

namespace App\Contracts\Support;

use App\Models\CountryCity;

interface CountryCityInterface
{
    public function getCacheName(): string;

    public function clearCache(): void;

    /**
     * @param  array<string, mixed> $params
     * @return array<int,           mixed>
     */
    public function getCitySuggestions(array $params): array;

    /**
     * @return array<CountryCity>
     */
    public function getCities(): array;

    public function getCity(string $cityCode): ?CountryCity;

    public function getDefaultCityCode(): string;
}
