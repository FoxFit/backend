<?php

namespace App\Models;


use App\Contracts\Entity;
use App\Traits\HasEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string       $state_code
 * @property string       $city_code
 * @property string       $fips_code
 * @property string       $post_codes
 * @property string       $name
 * @property int          $ordering
 * @property CountryChild $countryChild
 */
class CountryCity extends Model implements Entity
{
    use HasEntity;
    use HasFactory;

    public const ENTITY_TYPE = 'country_city';

    protected $table = 'core_country_cities';

    public $timestamps = false;

    protected $fillable = [
        'state_code',
        'city_code',
        'fips_code',
        'post_codes',
        'name',
        'ordering',
    ];

    public function countryChild(): BelongsTo
    {
        return $this->belongsTo(CountryChild::class, 'state_code', 'state_code');
    }
}
