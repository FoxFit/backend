<?php

namespace App\Support;

class UserRole
{
    /**
     * @var string
     */
    public const SUPER_ADMIN_USER = 'Super Administrator';

    /**
     * @var string
     */
    public const ADMIN_USER = 'Administrator';

    /**
     * @var string
     */
    public const STAFF_USER = 'Staff';

    /**
     * @var string
     */
    public const NORMAL_USER = 'Registered User';

    /**
     * @var string
     */
    public const GUEST_USER = 'Guest User';

    /**
     * @var string
     */
    public const BANNED_USER = 'Banned User';

    /**
     * @var int
     */
    public const SUPER_ADMIN_USER_ID = 1;

    /**
     * @var int
     */
    public const ADMIN_USER_ID = 2;

    /**
     * @var int
     */
    public const STAFF_USER_ID = 3;

    /**
     * @var int
     */
    public const NORMAL_USER_ID = 4;

    /**
     * @var int
     */
    public const GUEST_USER_ID = 5;

    /**
     * @var int
     */
    public const BANNER_USER_ID = 6;

    /**
     * Define default roles when install metafox:install.
     *
     * @var string[]
     */
    public const ROLES = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
        self::STAFF_USER,
        self::NORMAL_USER,
        self::GUEST_USER,
        self::BANNED_USER,
    ];

    /**
     * Admin role level. Per app will assign permissions to this role list.
     *
     * @var string[]
     */
    public const LEVEL_ADMINISTRATOR = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
    ];

    /**
     * Staff role level.
     *
     * @var string[]
     */
    public const LEVEL_STAFF = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
        self::STAFF_USER,
    ];

    /**
     * Registered user role level.
     *
     * @var string[]
     */
    public const LEVEL_REGISTERED = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
        self::STAFF_USER,
        self::NORMAL_USER,
    ];

    /**
     * Guest role level.
     *
     * @var string[]
     */
    public const LEVEL_GUEST = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
        self::STAFF_USER,
        self::NORMAL_USER,
        self::GUEST_USER,
    ];

    /**
     * Banned user role level.
     *
     * @var string[]
     */
    public const LEVEL_BANNED = [
        self::SUPER_ADMIN_USER,
        self::ADMIN_USER,
        self::STAFF_USER,
        self::NORMAL_USER,
        self::GUEST_USER,
        self::BANNED_USER,
    ];
}
