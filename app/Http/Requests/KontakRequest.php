<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KontakRequest extends FormRequest
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
        return [
            'unit' => 'nullable|string|max:100',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:255',
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
            'unit.max' => 'Nama unit tidak boleh lebih dari 100 karakter.',
            'nama.required' => 'Nama kontak wajib diisi.',
            'nama.max' => 'Nama kontak tidak boleh lebih dari 255 karakter.',
            'jabatan.max' => 'Jabatan tidak boleh lebih dari 100 karakter.',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 30 karakter.',
            'whatsapp.max' => 'Nomor WhatsApp tidak boleh lebih dari 30 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh negatif.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}
