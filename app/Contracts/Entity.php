<?php

namespace App\Contracts;

interface Entity
{
    public function entityId(): int;

    public function entityType(): string;
}
