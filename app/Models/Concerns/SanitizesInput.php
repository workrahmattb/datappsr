<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Strip HTML tags from common name-like text attributes on write
 * as a defense against stored XSS.
 *
 * Note: this deliberately uses method-based Eloquent attributes
 * (e.g. `nama()`, `namaKk()`) instead of returning `Attribute` objects
 * from `casts()`. Since Laravel 12, cast values must implement
 * `Stringable`, so putting `Attribute::make()` inside the `casts()`
 * array throws an `InvalidArgumentException`.
 *
 * Eloquent discovers method-based attributes automatically via
 * `method_exists($this, Str::camel($attribute))`, so the snake_case
 * field name maps to its camelCase method below.
 */
trait SanitizesInput
{
    protected function nama(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    protected function tempatLahir(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    protected function namaKk(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    protected function namaAyah(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    protected function namaIbu(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    protected function namaWali(): Attribute
    {
        return Attribute::make(set: fn ($value) => $this->sanitizeInput($value));
    }

    /**
     * Sanitize a single value: strip HTML tags from strings, leave
     * other values (e.g. null) untouched.
     */
    protected function sanitizeInput(mixed $value): mixed
    {
        return is_string($value) ? strip_tags($value) : $value;
    }
}
