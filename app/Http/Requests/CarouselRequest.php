<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarouselRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        $isUpdate = $this->route('carousel') !== null;

        return [
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'gambar' => ($isUpdate ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_url' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'judul.max' => 'Judul slide tidak boleh lebih dari 255 karakter.',
            'deskripsi.max' => 'Deskripsi tidak boleh lebih dari 500 karakter.',
            'gambar.required' => 'Gambar carousel wajib diunggah.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'link_url.max' => 'Tautan tidak boleh lebih dari 255 karakter.',
            'link_text.max' => 'Label tombol tidak boleh lebih dari 100 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh negatif.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}
