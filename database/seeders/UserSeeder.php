<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user - no company assignment for global access
        User::updateOrCreate(
            ['email' => 'admin@merzigo.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'source' => 'Merzigo',
            ]
        );

        // Editor users
        User::updateOrCreate(
            ['email' => 'editor@dogus.com'],
            [
                'name' => 'Editor User - Doğuş Dijital',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'source' => 'Merzigo',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@disney.com'],
            [
                'name' => 'Editor User - Disney+',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'source' => 'Solar',
            ]
        );

        // Viewer users
        User::updateOrCreate(
            ['email' => 'viewer@nowtv.com'],
            [
                'name' => 'Viewer User - Now Tv',
                'password' => Hash::make('password'),
                'role' => 'viewer',
                'source' => 'Merzigo',
            ]
        );

        User::updateOrCreate(
            ['email' => 'viewer@dogus.com'],
            [
                'name' => 'Viewer User - Doğuş Dijital',
                'password' => Hash::make('password'),
                'role' => 'viewer',
                'source' => 'Merzigo',
            ]
        );

        // Additional test users for comprehensive testing
        User::updateOrCreate(
            ['email' => 'editor@amazon.com'],
            [
                'name' => 'Editor User - Amazon Prime',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'source' => 'Solar',
            ]
        );

        User::updateOrCreate(
            ['email' => 'viewer@hbomax.com'],
            [
                'name' => 'Viewer User - HBO Max',
                'password' => Hash::make('password'),
                'role' => 'viewer',
                'source' => 'Merzigo',
            ]
        );
    }
}
