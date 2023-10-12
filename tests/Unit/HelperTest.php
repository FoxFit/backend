<?php

namespace Tests\Unit;

use App\Support\AppConstant;
use Tests\TestCase;

class HelperTest extends TestCase
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
}
