<?php

namespace App\Libraries;

use App\Models\UserAccount;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProfilePictureLibrary
{
    public function upload(UserAccount $userAccount, UploadedFile $profilePicture): string
    {
        $oldPath = $userAccount->profile_picture_path;
        $directory = 'user-profiles/'.$userAccount->id.'/profile-pictures';
        $extension = $this->preferredExtension();
        $relativePath = $directory.'/'.Str::uuid().'.'.$extension;
        $disk = Storage::disk('public');

        $disk->makeDirectory($directory);

        $image = Image::decode($profilePicture)->cover(300, 300);

        if ($extension === 'jpg') {
            $image->save($disk->path($relativePath), quality: 85);
        } else {
            $image->save($disk->path($relativePath));
        }

        $userAccount->update([
            'profile_picture_path' => $relativePath,
        ]);

        if (! empty($oldPath) && $oldPath !== $relativePath) {
            $disk->delete($oldPath);
        }

        return $relativePath;
    }

    private function preferredExtension(): string
    {
        return function_exists('imagejpeg') ? 'jpg' : 'png';
    }
}
