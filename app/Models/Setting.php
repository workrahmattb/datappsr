<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * In-memory cache per request. Declared as class property
     * so both value() and set() can access it.
     */
    protected static array $cache = [];

    /**
     * Get a setting value by key with optional default.
     * Results are cached in memory for the duration of the request.
     */
    public static function value(string $key, mixed $default = null): mixed
    {
        if (!isset(static::$cache[$key])) {
            $setting = static::where('key', $key)->first();
            static::$cache[$key] = $setting ? $setting->value : $default;
        }

        return static::$cache[$key];
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Clear cache so next read fetches the updated value
        unset(static::$cache[$key]);
    }

    /**
     * Get the active academic year setting.
     */
    public static function activeTahunAjaran(): string
    {
        return static::value('tahun_ajaran_aktif', '2026/2027');
    }
}
