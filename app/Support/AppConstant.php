<?php

namespace App\Support;

class AppConstant
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const FOOD_BY_QUANTITY = 1;
    public const FOOD_BY_GRAM = 2;

    public const SEARCH_FROM = 'from';
    public const SEARCH_TO = 'to';

    public const SEARCH_SORT = 'sort';
    public const SEARCH_SORT_BY = 'sort_by';
    public const SEARCH_FILTER_FIRST_SEEN = 'first_seen';
    public const SEARCH_FILTER_LAST_SEEN = 'last_seen';

    public const SEARCH_FILTER_CONVERT = [
        self::SEARCH_FILTER_FIRST_SEEN => 'created_at',
        self::SEARCH_FILTER_LAST_SEEN => 'last_login_at',
    ];

    /**
     * @return array<int, string>
     */
    public static function getGenders(): array
    {
        return [
            self::GENDER_MALE => __('app.male'),
            self::GENDER_FEMALE => __('app.female'),
        ];
    }

    /**
     * Convert search filter.
     *
     * @param string $key
     * @return string|null
     */
    public static function convertSearchFilter(string $key): ?string
    {
        if (!array_key_exists($key, self::SEARCH_FILTER_CONVERT)) {
            return null;
        }

        return self::SEARCH_FILTER_CONVERT[$key];
    }

    /**
     * Get per page.
     *
     * @param int $from
     * @param int $to
     * @return int
     */
    public static function getPerPage(int $from, int $to): int
    {
        return $to - $from + 1;
    }

    /**
     * Get current page.
     *
     * @param int $from
     * @param int $to
     * @return int
     */
    public static function getCurrentPage(int $from, int $to): int
    {
        return (($from + 1) / self::getPerPage($from, $to)) + 1;
    }
}
