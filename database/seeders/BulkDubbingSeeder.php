<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dubbing;
use App\Models\Show;
use App\Models\Studio;
use App\Models\Language;

class BulkDubbingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // title, languageName, status, studioName, duration
            ['O Hayat Benim','Arapça','Bitti','NOW',17366],
            ['Kader Bağları','İspanyolca','Bitti','NOW',615],
            ['Adı Zehra','Arapça','Bitti','NOW',2058],
            ['Aşk Yeniden','Arapça','Bitti','NOW',7032],
            ['Adı Zehra','İspanyolca','Bitti','NOW',2058],
            ['Ruhun Duymaz','İspanyolca','Bitti','NOW',1203],
            ['Kader Bağları','Arapça','Bitti','NOW',615],
            ['Bay Yanlış','İspanyolca','Bitti','NOW',1767],
            ['Zümrüdüanka','Arapça','Bitti','NOW',3646],
            ['Gülümse Kaderine','Arapça','Bitti','NOW',709],
            ['İnadına Aşk','İspanyolca','Bitti','NOW',3712],
            // ... diğer satırlar isteğe göre eklenebilir ...
        ];

        $langMap = [
            'Arapça' => 'ar',
            'İspanyolca' => 'es',
            'Farsça' => 'fa',
            'Portekizce' => 'pt',
            'Rusça' => 'ru',
            'Fransızca' => 'fr',
        ];

        $statusMap = [
            'Bitti' => 'completed',
            'Devam Ediyor' => 'in_progress',
            'Dublajda' => 'dubbing',
            'Yayınlandı' => 'published',
        ];

        $nowStudio = Studio::firstOrCreate(['name' => 'NOW'], [
            'source' => 'Merzigo',
            'unit_price' => 0,
        ]);
        $fallbackStudio = Studio::first();

        foreach ($rows as [$title, $langName, $statusTr, $studioName, $duration]) {
            $show = Show::where('name', $title)->first();
            if (!$show) { continue; }

            $languageCode = $langMap[$langName] ?? null;
            if (!$languageCode) { continue; }
            if (!Language::where('code', $languageCode)->exists()) { continue; }

            $studio = $studioName === 'NOW'
                ? $nowStudio
                : Studio::where('name', $studioName)->first();
            if (!$studio) { $studio = $fallbackStudio ?? $nowStudio; }

            $status = $statusMap[$statusTr] ?? 'completed';

            Dubbing::firstOrCreate(
                [
                    'show_id' => $show->id,
                    'language_code' => $languageCode,
                    'studio_id' => $studio->id,
                ],
                [
                    'duration' => (int) $duration,
                    'received_episodes' => 0,
                    'downloaded_episodes' => 0,
                    'published_episodes' => 0,
                    'status' => $status,
                    'notes' => null,
                ]
            );
        }
    }
}


