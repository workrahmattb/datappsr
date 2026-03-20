<?php

namespace Database\Seeders;

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
        // Admin (Super Admin)
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@ppsr.local'],
            [
                'name' => 'Super Administrator',
                'password' => \Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // MTs Putra
        \App\Models\User::updateOrCreate(
            ['email' => 'mtsputra@admin.com'],
            [
                'name' => 'Admin MTs Putra',
                'password' => \Hash::make('password'),
                'role' => 'mtsputra',
            ]
        );

        // MTs Putri
        \App\Models\User::updateOrCreate(
            ['email' => 'mtsputri@admin.com'],
            [
                'name' => 'Admin MTs Putri',
                'password' => \Hash::make('password'),
                'role' => 'mtsputri',
            ]
        );

        // MA Putra
        \App\Models\User::updateOrCreate(
            ['email' => 'maputra@admin.com'],
            [
                'name' => 'Admin MA Putra',
                'password' => \Hash::make('password'),
                'role' => 'maputra',
            ]
        );

        // MA Putri
        \App\Models\User::updateOrCreate(
            ['email' => 'maputri@admin.com'],
            [
                'name' => 'Admin MA Putri',
                'password' => \Hash::make('password'),
                'role' => 'maputri',
            ]
        );
    }
}
