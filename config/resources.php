<?php

use App\Models\User;
use App\Support\UserRole;

return [
    User::ENTITY_TYPE => [
        'view'     => UserRole::LEVEL_REGISTERED,
        'create'   => UserRole::LEVEL_REGISTERED,
        'update'   => UserRole::LEVEL_REGISTERED,
        'delete'   => UserRole::LEVEL_REGISTERED,
        'moderate' => UserRole::LEVEL_STAFF,
    ],
];
