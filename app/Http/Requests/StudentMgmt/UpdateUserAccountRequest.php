<?php

namespace App\Http\Requests\StudentMgmt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAccountRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => is_string($this->username) ? trim($this->username) : $this->username,
            'email' => is_string($this->email) ? trim($this->email) : $this->email,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

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
        $userAccountId = $this->route('user_account');

        return [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'alpha_dash',
                Rule::unique('user_accounts', 'username')->ignore($userAccountId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user_accounts', 'email')->ignore($userAccountId),
            ],
            'role' => ['required', 'string', Rule::in(['admin', 'student', 'teacher'])],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.max' => 'Username must not exceed 255 characters.',
            'username.alpha_dash' => 'Username may only contain letters, numbers, dashes, and underscores.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'role.required' => 'Role is required.',
            'role.in' => 'Role must be admin, student, or teacher.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'password_confirmation' => 'password confirmation',
        ];
    }
}
