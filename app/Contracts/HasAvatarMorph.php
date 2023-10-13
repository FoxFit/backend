<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;
/**
 * Interface HasAvatar.
 *
 * Determine a resource has privacy field.
 *
 * @property  MorphTo $avatar
 * @property  int     $avatar_id
 * @property  string  $avatar_type
 */
interface HasAvatarMorph extends HasAvatar
{
    /**
     * @return MorphTo
     */
    public function avatar(): morphTo;

    /**
     * @return int
     */
    public function getAvatarId(): int;

    /**
     * @return string
     */
    public function getAvatarType(): string;

    /**
     * @return array<string, mixed>
     */
    public function getAvatarDataEmpty(): array;
}
