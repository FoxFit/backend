<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getByEmail(string $value, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where('email', '=', $value)->first($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function getByUsername(string $value, array $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where('user_name', '=', $value)->first($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }
}
