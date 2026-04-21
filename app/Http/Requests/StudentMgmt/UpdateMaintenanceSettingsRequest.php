<?php

namespace App\Http\Requests\StudentMgmt;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_enabled' => $this->boolean('is_enabled'),
            'affected_routes' => $this->splitByNewLine($this->input('affected_routes_text')),
            'excluded_routes' => $this->splitByNewLine($this->input('excluded_routes_text')),
            'allowed_ips' => $this->splitByNewLine($this->input('allowed_ips_text')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_enabled' => ['required', 'boolean'],
            'title' => ['required', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:2000'],
            'estimated_completion' => ['nullable', 'string', 'max:120'],
            'status_code' => ['required', 'integer', 'between:200,599'],
            'retry_after_seconds' => ['nullable', 'integer', 'min:1', 'max:86400'],
            'affected_routes' => ['nullable', 'array'],
            'affected_routes.*' => ['required', 'string', 'max:255'],
            'excluded_routes' => ['nullable', 'array'],
            'excluded_routes.*' => ['required', 'string', 'max:255'],
            'allowed_ips' => ['nullable', 'array'],
            'allowed_ips.*' => ['required', 'ip'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a maintenance page title.',
            'status_code.between' => 'Status code must be between 200 and 599.',
            'allowed_ips.*.ip' => 'Each allowed IP entry must be a valid IP address.',
        ];
    }

    /**
     * @return list<string>
     */
    private function splitByNewLine(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value) ?: [])
            ->map(static fn (string $line): string => trim($line))
            ->filter(static fn (string $line): bool => $line !== '')
            ->values()
            ->all();
    }
}
