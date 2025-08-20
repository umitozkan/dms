<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Income;
use App\Models\Dubbing;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dubbings = Dubbing::all();

        foreach ($dubbings as $dubbing) {
            $incomeCount = rand(1, 3);

            for ($i = 0; $i < $incomeCount; $i++) {
                $merzigoCost = rand(2000, 8000);
                $price = rand(3000, 9000);
                $unitPrice = rand(100, 500);
                $revenue = $price + rand(500, 13000);

                Income::create([
                    'dubbing_id' => $dubbing->id,
                    'merzigo_cost' => $merzigoCost,
                    'price' => $price,
                    'unit_price' => $unitPrice,
                    'revenue' => $revenue,
                    'income_date' => now()->subDays(rand(1, 90)),
                    'end_date' => now()->subDays(rand(1, 30)),
                    'notes' => 'Test gelir kaydı ' . ($i + 1),
                ]);
            }
        }
    }
}
