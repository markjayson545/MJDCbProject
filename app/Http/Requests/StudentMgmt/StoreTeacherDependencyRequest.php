<?php

namespace App\Http\Requests\StudentMgmt;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherDependencyRequest extends FormRequest
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
            'department' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fname.required' => 'Teacher first name is required.',
            'lname.required' => 'Teacher last name is required.',
            'contactno.required' => 'Teacher contact number is required.',
            'email.required' => 'Teacher email is required.',
            'email.email' => 'Teacher email must be a valid email address.',
        ];
    }
}
