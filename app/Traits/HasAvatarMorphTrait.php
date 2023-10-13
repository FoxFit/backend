<?php

namespace App\Traits;

use App\Contracts\HasAvatarMorph;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Trait HasAvatarMorph.
 * @mixin HasRelationships
 * @mixin HasAvatarMorph
 * @property int    $avatar_id
 * @property string $avatar_type
 */
trait HasAvatarMorphTrait
{
    use HasAvatarTrait;

    public function avatar(): morphTo
    {
        return $this->morphTo('photo', 'avatar_type', 'avatar_id')->withDefault(false);
    }

    public function getAvatarId(): int
    {
        return $this->avatar_id;
    }

    public function getAvatarType(): string
    {
        return $this->avatar_type;
    }

    public function getAvatarDataEmpty(): array
    {
        return [
            'avatar_id'        => 0,
            'avatar_type'      => 'photo',
            'avatar_path'      => null,
            'avatar_server_id' => 0,
        ];
    }
}
