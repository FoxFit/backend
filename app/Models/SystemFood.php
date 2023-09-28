<?php

namespace App\Models;

use App\Contracts\Resource;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $protein
 * @property float $carbon
 * @property float $fat
 * @property int $user_id
 * @property int $type
 */
class SystemFood extends Model implements Resource
{
    protected $table = 'system_foods';

    public const ENTITY_TYPE = 'SYSTEM_FOOD';

    protected $fillable = [
        'name',
        'protein',
        'carbon',
        'fat',
        'type',
    ];

    public function entityId(): int
    {
        return $this->id;
    }

    public function entityType(): string
    {
        return self::ENTITY_TYPE;
    }

    public function userId(): int
    {
        return $this->user_id;
    }
}
