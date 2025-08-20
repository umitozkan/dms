<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $childCompanies = [
            [
                'name' => 'NOW TV',
                'contact_person' => 'Fatma Demir',
                'email' => 'info@nowtv.com',
                'phone' => '+90 216 555 0202',
                'address' => 'Kadıköy, İstanbul, Türkiye',
                'source' => 'Merzigo',
            ],
            [
                'name' => 'Doğuş Dijital',
                'contact_person' => 'Ahmet Yılmaz',
                'email' => 'contact@dogusdijital.com',
                'phone' => '+90 212 555 0101',
                'address' => 'Levent, İstanbul, Türkiye',
                'source' => 'Merzigo',
            ],
            [
                'name' => 'Disney+',
                'contact_person' => 'Jane Doe',
                'email' => 'contact@disneyplus.com',
                'phone' => '+1 123 456 7890',
                'address' => 'Burbank, CA, USA',
                'source' => 'Solar',
            ],
            [
                'name' => 'Amazon Prime',
                'contact_person' => 'John Doe',
                'email' => 'contact@amazonprime.com',
                'phone' => '+1 234 567 8901',
                'address' => 'Seattle, WA, USA',
                'source' => 'Solar',
            ],
            [
                'name' => 'HBO Max',
                'contact_person' => 'Mary Doe',
                'email' => 'contact@hbomax.com',
                'phone' => '+1 345 678 9012',
                'address' => 'New York, NY, USA',
                'source' => 'Solar',
            ],
        ];

        foreach ($childCompanies as $company) {
            Company::create($company);
        }
    }
}
