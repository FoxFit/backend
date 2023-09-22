<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @mixin BaseRepository
 */
interface UserRepositoryInterface
{
    /**
     * Find data by field and value
     *
     * @param string $value
     * @param array $columns
     * @return Collection
     * @throws RepositoryException
     */
    public function getByEmail(string $value, array $columns = ['*']);
}
