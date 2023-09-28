<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A Resource is created by user.
 */
interface Resource extends Entity
{
    public function userId(): int;
}
