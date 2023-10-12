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
     * Find user by email.
     *
     * @param string $value
     * @param array $columns
     * @return Collection
     * @throws RepositoryException
     */
    public function getByEmail(string $value, array $columns = ['*']);

    /**
     * Find user by user_name.
     *
     * @param string $value
     * @param array $columns
     * @return Collection
     * @throws RepositoryException
     */
    public function getByUsername(string $value, array $columns = ['*']);

    /**
     * Get all users.
     *
     * @param array $params
     * @param int $perPage
     * @param int $page
     * @return mixed
     */
    public function getAll(array $params, int $perPage, int $page);
}
