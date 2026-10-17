<?php

namespace App\Http\Requests;

use App\Rules\KetentuanUkuranGambar;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeritaRequest extends FormRequest
{
    /**
     * Ketentuan ukuran gambar thumbnail berita (lanskap 16:9).
     */
    public static function ketentuanThumbnail(): KetentuanUkuranGambar
    {
        return new KetentuanUkuranGambar(800, 450, 1.3, 2.2, '1200 × 675 px (16:9)');
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
        $beritaId = $this->route('berita')?->id;

        return [
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|'.Rule::unique('beritas', 'slug')->ignore($beritaId),
            'kategori' => 'nullable|string|max:100',
            'ringkasan' => 'nullable|string|max:500',
            'isi' => 'required|string',
            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                self::ketentuanThumbnail(),
            ],
            'penulis' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
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
            'judul.required' => 'Judul berita wajib diisi.',
            'judul.max' => 'Judul berita tidak boleh lebih dari 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan, silakan pakai slug lain.',
            'kategori.max' => 'Kategori tidak boleh lebih dari 100 karakter.',
            'ringkasan.max' => 'Ringkasan tidak boleh lebih dari 500 karakter.',
            'isi.required' => 'Isi berita wajib diisi.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 100 karakter.',
            'status.required' => 'Status berita wajib dipilih.',
            'status.in' => 'Status berita tidak valid.',
            'published_at.date' => 'Tanggal publikasi tidak valid.',
            'is_featured.boolean' => 'Nilai berita unggulan tidak valid.',
        ];
    }
}
