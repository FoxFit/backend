<?php

namespace App\Support;

class AppConstant
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    /**
     * @return array<int, string>
     */
    public static function getGenders(): array
    {
        return [
            self::GENDER_MALE   => __('app.male'),
            self::GENDER_FEMALE => __('app.female'),
        ];
    }
}
