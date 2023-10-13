<?php

namespace App\Http\Resources\Users;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserItem.
 *
 * Do not use Gate in here to improve performance.
 *
 * @property User $resource
 */
class UserItem extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'address' => null,
            'avatar' => $this->resource->profile->avatar_path,
            'birthday' => $this->resource->profile->birthday,
            'city' => $this->resource->profile->country_city_code,
            'email' => $this->resource->profile->avatar_path,
            'first_name' => $this->resource->first_name,
            'first_seen' => $this->resource->created_at,
            'groups' => ['regular'],
            'has_newsletter' => true,
            'has_ordered' => false,
            'last_name' => $this->resource->last_name,
            'last_seen' => $this->resource->last_login_at,
            'latest_purchase' => null,
            'nb_commands' => 0,
            'stateAbbr' => null,
            'total_spent' => 0,
            'zipcode' => $this->resource->profile->postal_code,
        ];
    }
}
