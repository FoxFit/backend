<?php

namespace App\Traits;


use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 */
class HasResource
{
    use HasEntity;

    public function userId(): int
    {
        return $this->user_id;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
