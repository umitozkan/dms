<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Dubbing;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dubbings = Dubbing::all();

        $scriptOptions = [true, false];
        $aeOptions = [true, false];
        $fileTypes = ['MP4', 'MOV', 'MKV', 'AVI'];

        foreach ($dubbings as $dubbing) {
            // Create 1-3 materials per dubbing
            $materialCount = rand(1, 3);

            for ($i = 0; $i < $materialCount; $i++) {
                Material::create([
                    'dubbing_id' => $dubbing->id,
                    'file_type' => $fileTypes[array_rand($fileTypes)],
                    'season_number' => rand(1, 4),
                    'episode_number' => rand(1, 12),
                    'script_exists' => $scriptOptions[array_rand($scriptOptions)],
                    'ae_file_exists' => $aeOptions[array_rand($aeOptions)],
                    'file_duration' => rand(10, 120),
                    'video_path' => '/videos/' . $dubbing->id . '_' . $i . '.mp4',
                    'script_file_path' => $scriptOptions[array_rand($scriptOptions)] ? '/scripts/' . $dubbing->id . '_' . $i . '.pdf' : null,
                    'ae_file_path' => $aeOptions[array_rand($aeOptions)] ? '/ae/' . $dubbing->id . '_' . $i . '.aep' : null,
                    'status' => ['sent_to_studio', 'completed'][rand(0, 1)],
                    'duration' => rand(20, 60),
                    'studio_start_date' => now()->subDays(rand(5, 15)),
                    'studio_end_date' => now()->subDays(rand(1, 5)),
                    'received_from_producer' => now()->subDays(rand(10, 30)),
                    'unit_price' => rand(50, 200),
                    'notes' => 'Test materyal ' . ($i + 1),
                ]);
            }
        }
    }
}
