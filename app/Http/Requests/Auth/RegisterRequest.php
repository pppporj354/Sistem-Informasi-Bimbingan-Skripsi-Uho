<?php


namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)
            ],
            'role' => [
                'required',
                'string',
                Rule::in(['student', 'lecturer'])
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                Rules\Password::defaults()
            ],
            'password_confirmation' => [
                'required',
                'string'
            ],
            'terms' => [
                'accepted'
            ],
            'nim' => [
                'required_if:role,student',
                'nullable',
                'string',
                'max:10',
                'min:4',
                'unique:students,nim',
                'regex:/^[0-9]*$/'
            ],
            'angkatan' => [
                'required_if:role,student',
                'nullable',
                'integer',
                'digits:4',
                'min:2000',
                'max:' . date('Y'),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama lengkap hanya boleh mengandung huruf dan spasi.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.string' => 'Alamat email harus berupa teks.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Alamat email sudah terdaftar dalam sistem.',
            'email.lowercase' => 'Alamat email harus dalam huruf kecil.',

            'role.required' => 'Peran dalam sistem wajib dipilih.',
            'role.string' => 'Peran harus berupa teks.',
            'role.in' => 'Peran yang dipilih tidak valid.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks.',

            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',

            'nim.required_if' => 'NIM wajib diisi untuk mahasiswa.',
            'nim.string' => 'NIM harus berupa teks.',
            'nim.max' => 'NIM tidak boleh lebih dari 10 karakter.',
            'nim.min' => 'NIM harus terdiri dari minimal 4 karakter.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nim.regex' => 'NIM hanya boleh mengandung angka.',

            'angkatan.required_if' => 'Angkatan wajib diisi untuk mahasiswa.',
            'angkatan.integer' => 'Angkatan harus berupa angka.',
            'angkatan.digits' => 'Angkatan harus terdiri dari 4 digit.',
            'angkatan.min' => 'Angkatan tidak boleh kurang dari 2000.',
            'angkatan.max' => 'Angkatan tidak boleh lebih dari tahun ini.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'alamat email',
            'role' => 'peran',
            'password' => 'kata sandi',
            'password_confirmation' => 'konfirmasi kata sandi',
            'terms' => 'syarat dan ketentuan',
            'nim' => 'NIM',
            'angkatan' => 'angkatan',
        ];
    }
}
