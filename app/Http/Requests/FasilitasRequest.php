<?php

namespace App\Http\Requests;

use App\Rules\KetentuanUkuranGambar;
use Illuminate\Foundation\Http\FormRequest;

class FasilitasRequest extends FormRequest
{
    /**
     * Maksimal jumlah foto yang boleh diunggah sekaligus.
     */
    public const MAX_FOTOS = 8;

    /**
     * Ketentuan ukuran foto fasilitas (lanskap 4:3).
     */
    public static function ketentuanFoto(): KetentuanUkuranGambar
    {
        return new KetentuanUkuranGambar(800, 600, 1.2, 1.8, '1200 × 900 px (4:3)');
    }

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
        $isUpdate = $this->route('fasilitas') !== null;

        return [
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'fotos' => $isUpdate
                ? 'nullable|array|max:'.self::MAX_FOTOS
                : 'required|array|min:1|max:'.self::MAX_FOTOS,
            'fotos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                self::ketentuanFoto(),
            ],
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
            'nama.required' => 'Nama fasilitas wajib diisi.',
            'nama.max' => 'Nama fasilitas tidak boleh lebih dari 255 karakter.',
            'kategori.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'fotos.required' => 'Minimal satu foto fasilitas wajib diunggah.',
            'fotos.array' => 'Foto fasilitas tidak valid.',
            'fotos.min' => 'Minimal satu foto fasilitas wajib diunggah.',
            'fotos.max' => 'Jumlah foto tidak boleh lebih dari '.self::MAX_FOTOS.' berkas sekali unggah.',
            'fotos.*.image' => 'Setiap berkas harus berupa gambar.',
            'fotos.*.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WebP.',
            'fotos.*.max' => 'Ukuran setiap foto tidak boleh lebih dari 2 MB.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh negatif.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}
