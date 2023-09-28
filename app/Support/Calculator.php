<?php

namespace App\Support;

use App\Models\SystemFood;

class Calculator
{
    private int $protein = 4;
    private int $carbon = 4;
    private int $fat = 9;

    private float $proteinNeeded = 0;
    private float $carbonNeeded = 0;
    private float $fatNeeded = 0;

    // https://www.thehinh.com/tool/TDEE/tinh-tdee.html
    private $TDEE;
    private $weight;

    const NORMAL_CALCULATOR = 0;
    const SPECIAL_CALCULATOR = 1;

    private $list = [30, 35, 35];
    private int $type;
    private array $foodList;

    private $foods = [];

    public function __construct(float $weight, float $TDEE, int $type = self::NORMAL_CALCULATOR)
    {
        $this->weight = $weight;
        $this->TDEE = $TDEE;
        $this->type = $type;
        $this->setFoods();
    }

    private function setFoods(): void {
        /** @var SystemFood[] $result */
        $result = SystemFood::query()->get();

        if (empty($result)) {
            return;
        }

        foreach ($result as $food) {
            $this->foods[$food->name] = [
                $food->protein,
                $food->carbon,
                $food->fat,
            ];
        }
    }

    public function setList(array $list): void
    {
        $this->list = $list;
    }

    public function setFoodList(array $foodList): void {
        $this->foodList = $foodList;
    }

    private function normalCalculator(): void
    {
        $this->proteinNeeded = (($this->TDEE / 100) * $this->list[0]) / $this->protein;
        $this->proteinNeeded = round($this->proteinNeeded);

        $this->carbonNeeded = (($this->TDEE / 100) * $this->list[1]) / $this->carbon;
        $this->carbonNeeded = round($this->carbonNeeded);

        $this->fatNeeded = (($this->TDEE / 100) * $this->list[2]) / $this->fat;
        $this->fatNeeded = round($this->fatNeeded);
    }

    public function calculator(): void
    {
        if ($this->type == self::SPECIAL_CALCULATOR) {
            $this->specialCalculator();
            return;
        }
        $this->normalCalculator();
    }

    private function specialCalculator(): void
    {
        // @todo
    }

    public function getTotalCalories(): float
    {
        return $this->proteinToCalo() + $this->carbonToCalo() + $this->fatToCalo();
    }

    public function showResult(): array
    {
        $this->calculator();

        $result = [
            'weight' => $this->weight,
            'protein' => $this->proteinNeeded,
            'carbon' => $this->carbonNeeded,
            'fat' => $this->fatNeeded,
            'total_calories' => $this->getTotalCalories(),
            'tdee' => $this->TDEE,
        ];

        $result['total'] = $this->calculateFood($this->foodList);

        return $result;
    }

    private function calculateFood(array $foodList): array {
        $totalProtein = $totalCarbon = $totalFat = 0;
        foreach ($foodList as $foodKey => $num) {
            $food = $this->foods[$foodKey];
            $protein = $food[0];
            $carbon = $food[1];
            $fat = $food[2];

            if ($protein > 0) {
                $totalProtein += $protein * $num;
            }

            if ($fat > 0) {
                $totalFat += $fat * $num;
            }

            if ($protein > 0) {
                $totalCarbon += $carbon * $num;
            }
        }

        return [$totalProtein, $totalCarbon, $totalFat];
    }

    public function proteinToCalo(): float
    {
        return $this->proteinNeeded * $this->protein;
    }

    public function carbonToCalo(): float
    {
        return $this->carbonNeeded * $this->carbon;
    }

    public function fatToCalo(): float
    {
        return $this->fatNeeded * $this->fat;
    }
}
