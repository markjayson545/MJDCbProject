<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProfilePictureUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_picture' => [
                'required',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'gif'])
                    ->max('2mb'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'profile_picture.required' => 'Please choose a profile picture to upload.',
            'profile_picture.image' => 'The uploaded file must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a JPEG, PNG, JPG, or GIF image.',
            'profile_picture.max' => 'The profile picture must not be larger than 2 MB.',
        ];
    }
}
