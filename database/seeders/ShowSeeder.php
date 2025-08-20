<?php

namespace Database\Seeders;

use App\Models\Show;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shows = [
            ['company_name' => 'NOW TV', 'name' => 'Stranger Things', 'total_episode' => 34, 'total_duration' => 1700, 'type' => 'series'],
            ['company_name' => 'NOW TV', 'name' => 'The Crown', 'total_episode' => 60, 'total_duration' => 3600, 'type' => 'series'],
            ['company_name' => 'Disney+', 'name' => 'The Mandalorian', 'total_episode' => 24, 'total_duration' => 1200, 'type' => 'series'],
            ['company_name' => 'Disney+', 'name' => 'WandaVision', 'total_episode' => 9, 'total_duration' => 450, 'type' => 'series'],
            ['company_name' => 'Amazon Prime', 'name' => 'The Boys', 'total_episode' => 24, 'total_duration' => 1300, 'type' => 'series'],
            ['company_name' => 'Amazon Prime', 'name' => 'Invincible', 'total_episode' => 16, 'total_duration' => 800, 'type' => 'series'],
            ['company_name' => 'HBO Max', 'name' => 'Game of Thrones', 'total_episode' => 73, 'total_duration' => 4200, 'type' => 'series'],
            ['company_name' => 'HBO Max', 'name' => 'Westworld', 'total_episode' => 36, 'total_duration' => 1900, 'type' => 'series'],
            ['company_name' => 'Doğuş Dijital', 'name' => "The Handmaid's Tale", 'total_episode' => 46, 'total_duration' => 2200, 'type' => 'series'],
            ['company_name' => 'Doğuş Dijital', 'name' => 'Ted Lasso', 'total_episode' => 34, 'total_duration' => 1700, 'type' => 'series'],
        ];

        foreach ($shows as $show) {
            $companyId = Company::where('name', $show['company_name'])->value('id');
            if (!$companyId) {
                continue;
            }
            Show::create([
                'company_id' => $companyId,
                'name' => $show['name'],
                'total_episode' => $show['total_episode'],
                'total_duration' => $show['total_duration'],
                'type' => $show['type'],
            ]);
        }
    }
}
