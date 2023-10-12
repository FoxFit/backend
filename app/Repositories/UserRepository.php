<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\AppConstant;

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

    public function getAll(array $params, int $perPage, int $page)
    {
        $model = $this->model->newQuery();

        if (array_key_exists(AppConstant::SEARCH_SORT, $params)) {
            $field = AppConstant::convertSearchFilter($params[AppConstant::SEARCH_SORT]);
            if ($field) {
                $sortBy = 'DESC';
                if (array_key_exists(AppConstant::SEARCH_SORT_BY, $params)) {
                    $sortBy = $params[AppConstant::SEARCH_SORT_BY];
                }
                $model->orderBy($field, $sortBy);
            }
        }

        $model->orderBy('id', 'DESC');

        return $this->parserResult($model->paginate($perPage, ['*'], 'page', $page));
    }
}
