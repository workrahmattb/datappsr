<?php

use App\Models\Setting;

if (!function_exists('activeTahunAjaran')) {
    /**
     * Get the active academic year from settings.
     */
    function activeTahunAjaran(): string
    {
        return Setting::activeTahunAjaran();
    }
}
