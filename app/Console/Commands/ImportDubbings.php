<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Show;
use App\Models\Studio;
use App\Models\Language;
use App\Models\Dubbing;

class ImportDubbings extends Command
{
    protected $signature = 'dubbings:import {--file= : CSV dosya yolu (varsayilan: storage/app/dubbings.csv)}';

    protected $description = 'CSV dosyasindan toplu dublaj kaydi olusturur';

    private array $languageMap = [
        // normalized ascii keys (diacritics removed, lowercased)
        'arapca' => 'ar', 'ar' => 'ar',
        'ispanyolca' => 'es', 'i̇spanyolca' => 'es', 'es' => 'es',
        'farsca' => 'fa', 'fa' => 'fa',
        'portekizce' => 'pt', 'pt' => 'pt',
        'rusca' => 'ru', 'ru' => 'ru',
        'fransizca' => 'fr', 'fr' => 'fr',
        'ingilizce' => 'en', 'en' => 'en',
        'turkce' => 'tr', 'tr' => 'tr',
    ];

    private array $statusMap = [
        'bitti' => 'completed', 'completed' => 'completed',
        'devam ediyor' => 'in_progress', 'in_progress' => 'in_progress',
        'dublajda' => 'dubbing', 'dubbing' => 'dubbing',
        'yayinlandi' => 'published', 'yayınlandı' => 'published', 'published' => 'published',
        'materyal bekliyor' => 'material_waiting',
    ];

    private function normalize(string $text): string
    {
        $lower = mb_strtolower($text, 'UTF-8');
        $map = [
            'ı' => 'i', 'İ' => 'i', 'I' => 'i',
            'ş' => 's', 'Ş' => 's',
            'ğ' => 'g', 'Ğ' => 'g',
            'ü' => 'u', 'Ü' => 'u',
            'ö' => 'o', 'Ö' => 'o',
            'ç' => 'c', 'Ç' => 'c',
        ];
        return strtr($lower, $map);
    }

    public function handle(): int
    {
        $path = $this->option('file') ?: storage_path('app/dubbings.csv');

        if (!file_exists($path)) {
            $this->error("CSV dosyasi bulunamadi: {$path}");
            $this->line('Ornek basliklar: title,language,status,studio,duration');
            return self::FAILURE;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->error('CSV dosyasi acilamadi');
            return self::FAILURE;
        }

        $header = fgetcsv($handle);
        if (!$header) {
            $this->error('CSV bos ya da hatali');
            fclose($handle);
            return self::FAILURE;
        }
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $idx = [
            'title' => array_search('title', $header, true),
            'language' => array_search('language', $header, true),
            'status' => array_search('status', $header, true),
            'studio' => array_search('studio', $header, true),
            'duration' => array_search('duration', $header, true),
        ];
        foreach ($idx as $k => $v) {
            if ($v === false) {
                $this->error("Eksik baslik: {$k}");
                fclose($handle);
                return self::FAILURE;
            }
        }

        $count = 0; $skipped = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $title = trim((string)($row[$idx['title']] ?? ''));
            $langLabel = trim((string)($row[$idx['language']] ?? ''));
            $statusLabel = trim((string)($row[$idx['status']] ?? ''));
            $studioName = trim((string)($row[$idx['studio']] ?? ''));
            $durationStr = trim((string)($row[$idx['duration']] ?? ''));

            if ($title === '') { $skipped++; continue; }

            $show = Show::where('name', $title)->first();
            if (!$show) { $this->warn("Atlandi (dizi yok): {$title}"); $skipped++; continue; }

            $langKey = $this->normalize($langLabel);
            $languageCode = $this->languageMap[$langKey] ?? null;
            if (!$languageCode || !Language::where('code', $languageCode)->exists()) {
                $this->warn("Atlandi (dil yok/haritalanamadi): {$title} - {$langLabel}");
                $skipped++; continue;
            }

            $status = $this->statusMap[$this->normalize($statusLabel)] ?? 'completed';

            $studio = null;
            if ($studioName !== '') {
                if (strtoupper($studioName) === 'NOW') {
                    $studio = Studio::firstOrCreate(['name' => 'NOW'], ['source' => 'Merzigo', 'unit_price' => 0]);
                } else {
                    $studio = Studio::firstOrCreate(['name' => $studioName], ['source' => 'Merzigo', 'unit_price' => 0]);
                }
            }
            if (!$studio) { $studio = Studio::first() ?? Studio::create(['name' => 'NOW','source'=>'Merzigo','unit_price'=>0]); }

            $duration = (int) preg_replace('/[^0-9]/', '', $durationStr);

            Dubbing::firstOrCreate(
                [
                    'show_id' => $show->id,
                    'language_code' => $languageCode,
                    'studio_id' => $studio->id,
                ],
                [
                    'duration' => $duration,
                    'received_episodes' => 0,
                    'downloaded_episodes' => 0,
                    'published_episodes' => 0,
                    'status' => $status,
                    'notes' => null,
                ]
            );
            $count++;
        }

        fclose($handle);
        $this->info("Islem tamam: eklenen/guncellenen: {$count}, atlanan: {$skipped}");
        return self::SUCCESS;
    }
}


