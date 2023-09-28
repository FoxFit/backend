<?php

namespace Support;

use App\Support\Calculator;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function testSuccess(): void {
        $TDEE = 1952;
        $weight = 52;

        $fit = new Calculator($weight, $TDEE);
        $fit->setList([30, 50, 20]);
        $fit->setFoodList([
            'chicken' => 2,
            'rice' => 4,
            'hamburger' => 1,
            'banana' => 2,
            'whey' => 2,
            'vinamilk_yaourt' => 2,
            'cheese' => 2,
            'true_milk_no_sugar_220ml' => 2,
            'watermelon' => 1,
        ]);
        $data = $fit->showResult();

        $this->assertEquals([
            'weight' => 52,
            'protein' => 146,
            'carbon' => 244,
            'fat' => 43,
            'total_calories' => 1947,
            'tdee' => 1952,
            'total' => [
                148.74999999999997,
                264.51,
                43.18,
            ],
        ], $data);
    }
}
