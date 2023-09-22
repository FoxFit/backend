<?php

namespace App\Traits;

/**
 * Trait HasEntity.
 *
 * @property string $primaryKey
 */

trait HasEntity
{
    public function entityId(): int
    {
        return $this->{$this->primaryKey};
    }

    public function entityType(): string
    {
        return self::ENTITY_TYPE;
    }
}
