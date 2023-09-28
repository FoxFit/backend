<?php

namespace App\Support;

class AppConstant
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const FOOD_BY_QUANTITY = 1;
    public const FOOD_BY_GRAM = 2;

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
