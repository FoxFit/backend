<?php

use App\Support\UserRole;

return [
    [
        'email'    => env('SITE_EMAIL', 'dev@fit.com'),
        'password' => env('SITE_PASSWORD', '123456'),
        'name'     => env('SITE_USERNAME', 'admin'),
        'role'     => UserRole::SUPER_ADMIN_USER,
        'username' => 'admin',
    ],
    [
        'email'    => 'test@fit.com',
        'password' => '123456',
        'name'     => 'test',
        'role'     => UserRole::NORMAL_USER,
        'username' => 'test',
    ],
    [
        'email'    => 'brian@fit.com',
        'password' => '123456',
        'name'     => 'Brian',
        'role'     => UserRole::NORMAL_USER,
        'username' => 'brian',
    ],
    [
        'email'    => 'terry@fit.com',
        'password' => '123456',
        'name'     => 'Terry',
        'role'     => UserRole::NORMAL_USER,
        'username' => 'terry',
    ],
    [
        'email'    => 'luna@fit.com',
        'password' => '123456',
        'name'     => 'Luna',
        'role'     => UserRole::NORMAL_USER,
        'username' => 'luna',
    ],
    [
        'email'    => 'katie@fit.com',
        'password' => '123456',
        'name'     => 'Katie',
        'role'     => UserRole::NORMAL_USER,
        'username' => 'katie',
    ],
];
