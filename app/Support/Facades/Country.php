<?php

namespace App\Support\Facades;

use App\Contracts\Support\CountryInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Class Country.
 *
 * @method array getAllActiveCountries()
 * @method void clearCache()
 * @method array getCountries()
 * @method array|null getCountry(string $countryIso)
 * @method string|null getCountryName(string $countryIso)
 * @method array buildCountrySearchForm()
 * @method array getCountryStates(string $countryIso)
 * @method string getCountryStateName(string $countryIso, string $stateIso)
 * @method string getDefaultCountryIso()
 * @method string getDefaultCountryStateIso()
 * @see \App\Support\Country
 */
class Country extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CountryInterface::class;
    }
}
