<?php

namespace Database\Seeders;

use App\Models\Dubbing;
use App\Models\Show;
use App\Models\Language;
use App\Models\Studio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DubbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dubbings = [
            ['show' => 'Stranger Things', 'language' => 'es', 'studio' => 'ProCast Art Production', 'duration' => 45, 'received_episodes' => 10, 'downloaded_episodes' => 8, 'published_episodes' => 5, 'status' => 'dubbing', 'notes' => 'Dublaj devam ediyor'],
            ['show' => 'Stranger Things', 'language' => 'fr', 'studio' => 'Studio13', 'duration' => 45, 'received_episodes' => 10, 'downloaded_episodes' => 10, 'published_episodes' => 10, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'The Crown', 'language' => 'de', 'studio' => 'ProCast Art Production', 'duration' => 60, 'received_episodes' => 5, 'downloaded_episodes' => 3, 'published_episodes' => 0, 'status' => 'material_waiting', 'notes' => 'Materyal bekleniyor'],
            ['show' => 'The Crown', 'language' => 'it', 'studio' => 'Les Company', 'duration' => 60, 'received_episodes' => 5, 'downloaded_episodes' => 5, 'published_episodes' => 2, 'status' => 'published', 'notes' => 'Yayında'],
            ['show' => 'The Mandalorian', 'language' => 'pt', 'studio' => 'Studio13', 'duration' => 35, 'received_episodes' => 8, 'downloaded_episodes' => 6, 'published_episodes' => 4, 'status' => 'in_progress', 'notes' => 'Devam ediyor'],
            ['show' => 'The Mandalorian', 'language' => 'ru', 'studio' => 'ProCast Art Production', 'duration' => 35, 'received_episodes' => 8, 'downloaded_episodes' => 8, 'published_episodes' => 8, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'WandaVision', 'language' => 'ja', 'studio' => 'Les Company', 'duration' => 30, 'received_episodes' => 12, 'downloaded_episodes' => 10, 'published_episodes' => 7, 'status' => 'dubbing', 'notes' => 'Dublaj devam ediyor'],
            ['show' => 'WandaVision', 'language' => 'ko', 'studio' => 'Studio13', 'duration' => 30, 'received_episodes' => 12, 'downloaded_episodes' => 12, 'published_episodes' => 12, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'The Boys', 'language' => 'zh', 'studio' => 'ProCast Art Production', 'duration' => 50, 'received_episodes' => 6, 'downloaded_episodes' => 4, 'published_episodes' => 2, 'status' => 'in_progress', 'notes' => 'Devam ediyor'],
            ['show' => 'The Boys', 'language' => 'ar', 'studio' => 'Les Company', 'duration' => 50, 'received_episodes' => 6, 'downloaded_episodes' => 6, 'published_episodes' => 6, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'Invincible', 'language' => 'tr', 'studio' => 'Studio13', 'duration' => 25, 'received_episodes' => 15, 'downloaded_episodes' => 12, 'published_episodes' => 8, 'status' => 'dubbing', 'notes' => 'Dublaj devam ediyor'],
            ['show' => 'Game of Thrones', 'language' => 'es', 'studio' => 'ProCast Art Production', 'duration' => 55, 'received_episodes' => 4, 'downloaded_episodes' => 2, 'published_episodes' => 0, 'status' => 'material_waiting', 'notes' => 'Materyal bekleniyor'],
            ['show' => 'Game of Thrones', 'language' => 'fr', 'studio' => 'Studio13', 'duration' => 55, 'received_episodes' => 4, 'downloaded_episodes' => 4, 'published_episodes' => 4, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'Westworld', 'language' => 'de', 'studio' => 'Les Company', 'duration' => 60, 'received_episodes' => 3, 'downloaded_episodes' => 3, 'published_episodes' => 3, 'status' => 'completed', 'notes' => 'Tamamlandı'],
            ['show' => 'The Handmaid\'s Tale', 'language' => 'it', 'studio' => 'ProCast Art Production', 'duration' => 45, 'received_episodes' => 7, 'downloaded_episodes' => 5, 'published_episodes' => 3, 'status' => 'in_progress', 'notes' => 'Devam ediyor'],
            ['show' => 'Ted Lasso', 'language' => 'pt', 'studio' => 'Studio13', 'duration' => 30, 'received_episodes' => 20, 'downloaded_episodes' => 18, 'published_episodes' => 15, 'status' => 'published', 'notes' => 'Yayında'],
        ];

        foreach ($dubbings as $dubbing) {
            $showId = Show::where('name', $dubbing['show'])->value('id');
            $languageCode = Language::where('code', $dubbing['language'])->value('code');
            $studioId = Studio::where('name', $dubbing['studio'])->value('id');

            if (!$showId || !$languageCode || !$studioId) {
                continue;
            }

            Dubbing::create([
                'show_id' => $showId,
                'language_code' => $languageCode,
                'studio_id' => $studioId,
                'duration' => $dubbing['duration'],
                'received_episodes' => $dubbing['received_episodes'],
                'downloaded_episodes' => $dubbing['downloaded_episodes'],
                'published_episodes' => $dubbing['published_episodes'],
                'status' => $dubbing['status'],
                'notes' => $dubbing['notes'],
            ]);
        }
    }
}
