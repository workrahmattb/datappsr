<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        // Set default tahun ajaran aktif
        Setting::firstOrCreate(
            ['key' => 'tahun_ajaran_aktif'],
            ['value' => '2026/2027']
        );

        // Set default header image
        Setting::firstOrCreate(
            ['key' => 'header_image'],
            ['value' => 'images/psb.webp']
        );

        $this->command->info('✅ Setting tahun ajaran aktif berhasil dibuat: 2026/2027');
        $this->command->info('✅ Setting header image berhasil dibuat: images/psb.webp');
    }
}
