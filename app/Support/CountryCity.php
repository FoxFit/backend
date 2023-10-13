<?php

namespace App\Support;

use App\Contracts\Support\CountryCityInterface;
use App\Models\CountryCity as Model;
use App\Repositories\Contracts\CountryCityRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class CountryCity implements CountryCityInterface
{
    public const CITY_SUGGESTION_LIMIT = 10;
    public const DEFAULT_CITY_CODE = '1580578';

    /**
     * @var array<string, Model>
     */
    private array $cities;

    private CountryCityRepositoryInterface $cityRepository;

    public function __construct(CountryCityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->init();
    }

    public function getCacheName(): string
    {
        return CacheManager::CORE_COUNTRY_CITY_CACHE;
    }

    public function clearCache(): void
    {
        Cache::forget($this->getCacheName());
    }

    /**
     * @param  array<string, mixed> $params
     * @return array<int,           mixed>
     */
    public function getCitySuggestions(array $params): array
    {
        $cities = $this->cityRepository->viewCities($params);

        return $cities->map(function (Model $city) {
            return [
                'label' => $city->name,
                'value' => $city->city_code,
            ];
        })->toArray();
    }

    protected function init(): void
    {
        $this->cities = Model::query()
            ->orderBy('ordering')
            ->orderBy('name')
            ->get()
            ->keyBy('city_code')
            ->all();
    }

    public function getCities(): array
    {
        return $this->cities;
    }

    public function getCity(string $cityCode): ?Model
    {
        return $this->cities[$cityCode] ?? null;
    }

    public function getDefaultCityCode(): string
    {
        return self::DEFAULT_CITY_CODE;
    }
}
