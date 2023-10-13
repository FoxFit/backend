<?php

namespace App\Support\Facades;

use App\Contracts\Support\CountryCityInterface;
use Illuminate\Support\Facades\Facade;
use App\Models\CountryCity as Model;

/**
 * Class CountryCity.
 *
 * @method array getCitySuggestions(array $params)
 * @method Model|null getCity(string $cityCode)
 * @method void clearCache()
 * @method string getDefaultCityCode()
 *
 * @see CountryCitySupportContract
 */
class CountryCity extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CountryCityInterface::class;
    }
}
