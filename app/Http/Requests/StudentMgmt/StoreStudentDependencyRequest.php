<?php

namespace App\Http\Requests\StudentMgmt;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentDependencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fname' => ['required', 'string', 'min:2', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'min:2', 'max:255'],
            'contactno' => ['required', 'string', 'min:7', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fname.required' => 'Student first name is required.',
            'lname.required' => 'Student last name is required.',
            'contactno.required' => 'Student contact number is required.',
            'email.required' => 'Student email is required.',
            'email.email' => 'Student email must be a valid email address.',
        ];
    }
}
