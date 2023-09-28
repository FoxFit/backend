<?php

namespace Database\Seeders;

use App\Models\SystemFood;
use App\Support\AppConstant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemFoodSeeder extends Seeder
{
    /**
     * Seed System food.
     */
    public function run(): void
    {
        $systemFoods = config('system_foods');

        $byQuantityFoods = $systemFoods['by_quantity'];
        $byGramFoods = $systemFoods['by_gram'];

        if (!empty($byQuantityFoods)) {
            $byQuantityFoodsForInsert = [];
            foreach ($byQuantityFoods as $name => $dataFood) {
                [$protein, $carbon, $fat] = $dataFood;
                $byQuantityFoodsForInsert[] = [
                    'name' => $name,
                    'protein' => $protein,
                    'carbon' => $carbon,
                    'fat' => $fat,
                    'type' => AppConstant::FOOD_BY_QUANTITY,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            SystemFood::query()->insert($byQuantityFoodsForInsert);
        }

        if (!empty($byGramFoods)) {
            $byGramFoodsForInsert = [];
            foreach ($byGramFoods as $name => $dataFood) {
                [$protein, $carbon, $fat] = $dataFood;
                $byGramFoodsForInsert[] = [
                    'name' => $name,
                    'protein' => $protein,
                    'carbon' => $carbon,
                    'fat' => $fat,
                    'type' => AppConstant::FOOD_BY_GRAM,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            SystemFood::query()->insert($byGramFoodsForInsert);
        }
    }
}
