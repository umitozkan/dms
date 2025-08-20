<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = [
            [
                'name' => 'ProCast Art Production',
                'source' => 'Merzigo',
                'unit_price' => 150.00,
                'address' => 'Damascus - Syria',
                'country' => 'Syria',
                'contact_person' => 'Abd Allah Malla Mahmood',
                'phone' => '+963933385307',
                'email' => null,
            ],
            [
                'name' => 'Studio13',
                'source' => 'Merzigo',
                'unit_price' => 175.00,
                'address' => 'Republic of Belarus, 220002, Minsk city,
Storozhovskaya street, house 8, room 6n, office 6n-1',
                'country' => 'Belarus',
                'contact_person' => 'Dmitri Sanko',
                'phone' => '+375 44 713-59-91',
                'email' => null,
            ],
            [
                'name' => 'Les Company',
                'source' => 'Solar',
                'unit_price' => 160.00,
                'address' => 'Miami, Florida',
                'country' => 'Florida',
                'contact_person' => 'Pedro Herrera',
                'phone' => '+1 (305) 560-6271',
                'email' => null,
            ],
            [
                'name' => 'GoGlobal',
                'source' => 'Solar',
                'unit_price' => 180.00,
                'address' => 'Esmeralda 1061
Piso 2, Oficina 4
Buenos Aires, C1007
Argentina',
                'country' => 'Argentina',
                'contact_person' => 'PAULA FERRARI',
                'phone' => '+34 699 44 71 39',
                'email' => 'paula.ferrari@goglobal-consulting.com',
            ],
            [
                'name' => 'Jarpa',
                'source' => 'Merzigo',
                'unit_price' => 155.00,
                'address' => 'Av. Paseo de la Reforma 440
Lomas de Chapultepec,',
                'country' => 'México',
                'contact_person' => 'Fernando Monroy',
                'phone' => '+52 (55) 5280 5711',
                'email' => 'fernando@jarpa.com',
            ],
            [
                'name' => 'Ares Media',
                'source' => 'Merzigo',
                'unit_price' => 165.00,
                'address' => 'Kireçburnu Mah. Arabayolu Cad. No:136 Tarabya, Sarıyer',
                'country' => 'İstanbul / Türkiye',
                'contact_person' => 'Mücahit Taha',
                'phone' => '+90 507 961 82 20',
                'email' => 'mucahittaha@aresmedia.net',
            ],
            [
                'name' => 'Doğuş Medya Grubu',
                'source' => 'Solar',
                'unit_price' => 170.00,
                'address' => 'Ahi Evran Cad. N°: 4 34398 Maslak - Sarıyer / İstanbul / TÜRKİYE',
                'country' => 'İstanbul / Türkiye',
                'contact_person' => 'Alp YILMAZ',
                'phone' => '+90 532 135 20 75',
                'email' => 'alp.yilmaz@dogusyayingrubu.com',
            ],
            [
                'name' => 'Farsi Voices',
                'source' => 'Merzigo',
                'unit_price' => 150.00,
                'address' => 'Dumlupınar Mh. Yumurtacı Abdi Bey Cd. Yenitepe Kadıköy projesi. 1. Etap B blok Kadıköy/ Istanbul',
                'country' => 'İstanbul / Türkiye',
                'contact_person' => 'Mohammed Reza',
                'phone' => '+90 555 144 10 37',
                'email' => 'moh.reza@farsivoices.com',
            ],
            [
                'name' => 'Binevi',
                'source' => 'Merzigo',
                'unit_price' => 140.00,
                'address' => '--',
                'country' => 'İstanbul / Türkiye',
                'contact_person' => 'Levent Erim',
                'phone' => '0535 772 8262',
                'email' => 'levent@bineviajans.com.tr',
            ],
        ];

        foreach ($studios as $studio) {
            Studio::create($studio);
        }
    }
}
