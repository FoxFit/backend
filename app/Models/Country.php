<?php

namespace App\Models;

use App\Contracts\Entity;
use App\Traits\HasEntity;
use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model implements Entity
{
    use HasEntity;
    use HasFactory;

    public const ENTITY_TYPE = 'country';

    protected $table = 'core_countries';

    protected $fillable = [
        'country_iso',
        'code',
        'code3',
        'numeric_code',
        'geonames_code',
        'fips_code',
        'area',
        'currency',
        'phone_prefix',
        'mobile_format',
        'landline_format',
        'trunk_prefix',
        'population',
        'continent',
        'language',
        'name',
        'ordering',
        'is_active',
    ];

    public $timestamps = false;

    /**
     * @return CountryFactory
     */
    protected static function newFactory()
    {
        return CountryFactory::new();
    }

    public function states(): HasMany
    {
        return $this->hasMany(CountryChild::class, 'country_iso', 'country_iso');
    }
}
