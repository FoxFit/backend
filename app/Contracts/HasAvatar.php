<?php

namespace App\Contracts;

/**
 * Interface HasAvatar.
 *
 * Determine a resource has avatar field.
 *
 * @property string|null                   $avatar
 * @property array<int|string, mixed>|null $avatars
 */
interface HasAvatar
{
    /**
     * @return string|null
     */
    public function getAvatarPath(): ?string;

    /**
     * @return int
     */
    public function getAvatarServerId(): int;

    /**
     * @return array<int>
     */
    public function getAvatarSizes(): array;

    /**
     * @return string|null
     */
    public function getAvatarAttribute(): ?string;

    /**
     * @return array<string, mixed>|null
     */
    public function getAvatarsAttribute(): ?array;
}
