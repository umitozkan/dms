<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English',   'code' => 'en'],
            ['name' => 'Spanish',   'code' => 'es'],
            ['name' => 'French',    'code' => 'fr'],
            ['name' => 'German',    'code' => 'de'],
            ['name' => 'Italian',   'code' => 'it'],
            ['name' => 'Portuguese','code' => 'pt'],
            ['name' => 'Russian',   'code' => 'ru'],
            ['name' => 'Japanese',  'code' => 'ja'],
            ['name' => 'Korean',    'code' => 'ko'],
            ['name' => 'Chinese',   'code' => 'zh'],
            ['name' => 'Arabic',    'code' => 'ar'],
            ['name' => 'Turkish',   'code' => 'tr'],
            ['name' => 'Hindi',     'code' => 'hi'],
            ['name' => 'Bengali',   'code' => 'bn'],
            ['name' => 'Urdu',      'code' => 'ur'],
            ['name' => 'Vietnamese','code' => 'vi'],
            ['name' => 'Thai',      'code' => 'th'],
            ['name' => 'Indonesian','code' => 'id'],
            ['name' => 'Malay',     'code' => 'ms'],
            ['name' => 'Filipino',  'code' => 'tl'],
            ['name' => 'Swahili',   'code' => 'sw'],
            ['name' => 'Farsça',   'code' => 'fa'],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
