<?php

namespace App\Support;

use App\Models\Setting;

class AdmissionPeriod
{
    public const STAGES = [
        'registration' => 'Awal penerimaan',
        'both' => 'Keduanya dibuka',
        'reregistration' => 'Penerimaan calon baru selesai',
        'closed' => 'Semua proses selesai',
    ];

    public static function year(): string
    {
        return Setting::query()->where('key', 'tahun_ajaran_aktif')->value('value') ?? '2026/2027';
    }

    public static function key(string $year): string
    {
        return 'admission_stage_'.$year;
    }

    public static function stage(?string $year = null): string
    {
        return Setting::query()->where('key', self::key($year ?? self::year()))->value('value') ?? 'both';
    }

    public static function registrationOpen(): bool
    {
        return in_array(self::stage(), ['registration', 'both'], true);
    }

    public static function reregistrationOpen(): bool
    {
        return in_array(self::stage(), ['reregistration', 'both'], true);
    }
}
