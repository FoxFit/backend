<?php

namespace App\Repositories;

use App\Models\CountryCity;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CountryCityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CountryCityRepository extends BaseRepository implements CountryCityRepositoryInterface
{
    public function model()
    {
        return CountryCity::class;
    }

    /**
     * @param  array<string, mixed> $attributes
     * @return Collection<Model>
     */
    public function viewCities(array $attributes): Collection
    {
        $limit = $attributes['limit'];
        $search = $attributes['q'] ?? '';
        $country = $attributes['country'] ?? null;

        $query = $this->getModel()->newQuery();

        if ($search) {
            $query->where(DB::raw('lower(core_country_cities.name)'), 'like', Str::lower($search) . '%');
        }

        if ($country) {
            $query->whereHas('countryChild', function (Builder $q) use ($country) {
                $q->where('core_country_states.country_iso', '=', $country);
            });
        }

        return $query->orderByDesc('core_country_cities.ordering')
            ->orderBy('core_country_cities.city_code')
            ->limit($limit)
            ->get('core_country_cities.*');
    }
}
