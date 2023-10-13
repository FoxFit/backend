<?php

namespace App\Models;

use App\Contracts\Entity;
use App\Traits\HasEntity;
use Database\Factories\CountryChildFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class CountryChild.
 *
 * @property int                      $id
 * @property string                   $country_iso
 * @property string                   $state_iso
 * @property int                      $state_code
 * @property int                      $geonames_code
 * @property string                   $fips_code
 * @property string                   $post_codes
 * @property string                   $name
 * @property string                   $timezone
 * @property int                      $ordering
 * @property Country                  $country
 * @property Collection|CountryCity[] $cities
 */
class CountryChild extends Model implements Entity
{
    use HasEntity;
    use HasFactory;

    public const ENTITY_TYPE = 'country_state';

    protected $table = 'core_country_states';

    protected $fillable = [
        'country_iso',
        'state_iso',
        'state_code',
        'geonames_code',
        'fips_code',
        'post_codes',
        'name',
        'timezone',
        'ordering',
    ];

    public $timestamps = false;

    /** @var array<string, string> */
    protected $casts = [
        'post_codes' => 'array',
    ];

    protected static function newFactory(): CountryChildFactory
    {
        return CountryChildFactory::new();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_iso', 'country_iso');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(CountryCity::class, 'state_code', 'state_code');
    }
}
