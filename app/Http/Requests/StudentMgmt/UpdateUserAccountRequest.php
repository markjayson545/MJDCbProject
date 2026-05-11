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
        $currentUserAccountId = is_object($userAccountId) ? $userAccountId->id : $userAccountId;

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
            'student_id' => [
                'nullable',
                'integer',
                'required_if:role,student',
                'prohibited_unless:role,student',
                Rule::exists('students', 'id')->where(function ($query) use ($currentUserAccountId) {
                    $query->whereNull('user_account_id')
                        ->orWhere('user_account_id', $currentUserAccountId);
                }),
            ],
            'teacher_id' => [
                'nullable',
                'integer',
                'required_if:role,teacher',
                'prohibited_unless:role,teacher',
                Rule::exists('teachers', 'id')->where(function ($query) use ($currentUserAccountId) {
                    $query->whereNull('user_account_id')
                        ->orWhere('user_account_id', $currentUserAccountId);
                }),
            ],
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
            'student_id.required_if' => 'Please select a student dependency for this student account.',
            'student_id.prohibited_unless' => 'Student dependency can only be selected for student accounts.',
            'student_id.exists' => 'The selected student is not available for linking.',
            'teacher_id.required_if' => 'Please select a teacher dependency for this teacher account.',
            'teacher_id.prohibited_unless' => 'Teacher dependency can only be selected for teacher accounts.',
            'teacher_id.exists' => 'The selected teacher is not available for linking.',
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
