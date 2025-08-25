<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'HoD', 'lecturer', 'student'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Student specific fields
            'nim' => ['required_if:role,student', 'nullable', 'string', 'unique:students,nim'],
            'lecturer_id_1' => ['nullable', 'exists:lecturers,id'],
            'lecturer_id_2' => ['nullable', 'exists:lecturers,id'],

            // Lecturer/HoD specific fields
            'nidn' => ['required_if:role,lecturer', 'required_if:role,HoD', 'nullable', 'string'],
            'nip' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'role.required' => 'Peran pengguna harus dipilih.',
            'role.in' => 'Peran pengguna tidak valid.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'nim.required_if' => 'NIM harus diisi untuk mahasiswa.',
            'nim.unique' => 'NIM sudah digunakan oleh mahasiswa lain.',
            'nidn.required_if' => 'NIDN harus diisi untuk dosen.',
            'lecturer_id_1.exists' => 'Dosen pembimbing 1 tidak valid.',
            'lecturer_id_2.exists' => 'Dosen pembimbing 2 tidak valid.',
        ];
    }
}
