<?php

namespace App\Models\Concerns;

/**
 * Strip HTML tags from the attributes listed in the model's
 * `$sanitizedTextFields` array whenever they are written, as a
 * defense against stored XSS.
 *
 * Usage inside a model:
 *
 *     use SanitizesTextFields;
 *
 *     protected array $sanitizedTextFields = ['judul', 'ringkasan', 'isi'];
 */
trait SanitizesTextFields
{
    /**
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        $fields = property_exists($this, 'sanitizedTextFields') ? $this->sanitizedTextFields : [];

        if (is_string($value) && in_array($key, $fields, true)) {
            $value = strip_tags($value);
        }

        return parent::setAttribute($key, $value);
    }
}
