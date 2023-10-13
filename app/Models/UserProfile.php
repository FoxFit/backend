<?php

namespace App\Models;

use App\Contracts\Entity;
use App\Contracts\HasAvatarMorph;
use App\Traits\HasAvatarMorphTrait;
use App\Traits\HasEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class UserProfile.
 *
 * @property int         $id,
 * @property string      $phone_number
 * @property int         $gender
 * @property string|null $birthday
 * @property int|null    $birthday_doy
 * @property string|null $birthday_search
 * @property string      $country_iso
 * @property int         $country_state_id
 * @property string      $country_city_code
 * @property string      $city_location
 * @property string      $postal_code
 * @property string      $language_id
 * @property int         $timezone_id
 * @property string      $currency_id
 * @property int         $dst_check
 * @property int         $server_id
 * @property string      $status
 * @property int         $invite_user_id
 * @property User        $user
 * @property User        $invite_user
 * @mixin  Builder
 */
class UserProfile extends Model implements Entity, HasAvatarMorph
{
    use HasEntity;
    use HasAvatarMorphTrait;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'phone_number',
        'full_phone_number',
        'gender',
        'birthday',
        'birthday_doy',
        'birthday_search',
        'country_iso',
        'country_state_id',
        'country_city_code',
        'city_location',
        'postal_code',
        'language_id',
        'timezone_id',
        'currency_id',
        'dst_check',
        'status',
        'invite_user_id',
        'avatar_type',
        'avatar_id',
        'avatar_path',
        'avatar_server_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id');
    }
}
