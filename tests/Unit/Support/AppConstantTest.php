<?php

namespace Support;

use App\Support\AppConstant;
use Tests\TestCase;

class AppConstantTest extends TestCase
{
    public static function get_current_page_provider(): array
    {
        return [
            [0, 4, 1],
            [5, 9, 2],
            [10, 14, 3],
            [15, 19, 4],
        ];
    }

    /**
     * @dataProvider get_current_page_provider
     *
     * @param int $from
     * @param int $to
     * @param int $page
     */
    public function test_get_current_page(int $from, int $to, int $page): void
    {
        $this->assertEquals($page, AppConstant::getCurrentPage($from, $to));
    }

    public static function get_per_page_provider(): array
    {
        return [
            [0, 4, 5],
            [0, 9, 10],
            [0, 14, 15],
            [0, 19, 20],
        ];
    }

    /**
     * @dataProvider get_per_page_provider
     *
     * @param int $from
     * @param int $to
     * @param int $perPage
     */
    public function test_get_per_page_provider(int $from, int $to, int $perPage)
    {
        $this->assertEquals($perPage, AppConstant::getPerPage($from, $to));
    }
}
