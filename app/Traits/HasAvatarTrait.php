<?php

namespace App\Traits;

use App\Contracts\HasAvatar;

/**
 * @mixin HasAvatar
 * @property string|null $avatar_path
 * @property int         $avatar_server_id
 */
trait HasAvatarTrait
{
    public function getAvatarPath(): ?string
    {
        return $this->avatar_path;
    }

    public function getAvatarServerId(): int
    {
        if ($this->avatar_server_id == null) {
            return StorageManager::LOCAL_STORAGE_ID;
        }

        return $this->avatar_server_id;
    }

    public function getAvatarSizes(): array
    {
        return [50, 120, 200];
    }

    public function getAvatarAttribute(): ?string
    {
        if (null === $this->getAvatarPath()) {
            return null;
        }

        return getFileUrl($this->getAvatarPath(), $this->getAvatarServerId());
    }

    public function getAvatarsAttribute(): ?array
    {
        if (null === $this->getAvatarPath()) {
            return null;
        }

        return (new Image(
            $this->getAvatarPath(),
            $this->getAvatarServerId(),
            $this->getAvatarSizes(),
            true
        ))->toArray();
    }
}
