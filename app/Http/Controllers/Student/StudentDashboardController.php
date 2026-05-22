<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Archived\Controller;
use App\Models\Student;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $studentId = $request->session()->get('student_id');

        $student = Student::query()
            ->with(['courses', 'degree.courses', 'userAccount'])
            ->findOrFail($studentId);

        $request->session()->put('student', $student);

        return view('student.student_dashboard');
    }

    public function uploadProfilePicture(Request $request): JsonResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $studentId = $request->session()->get('student_id');
        $userAccountId = $request->session()->get('user_account_id');

        $student = Student::query()
            ->whereKey($studentId)
            ->where('user_account_id', $userAccountId)
            ->with('userAccount')
            ->firstOrFail();

        $userAccount = $student->userAccount;

        if (! $userAccount instanceof UserAccount) {
            return response()->json([
                'success' => false,
                'message' => 'User account not found.',
            ], 404);
        }

        try {
            $image = $request->file('profile_picture');
            $manager = new ImageManager(new Driver);
            $imgResized = $manager->decode($image);
            $imgResized->resize(300, 300);

            $fileName = Str::uuid().'.jpg';
            $directory = 'user-profiles/'.$userAccountId.'/profile-pictures';
            Storage::disk('public')->makeDirectory($directory);

            $relativePath = $directory.'/'.$fileName;
            $absolutePath = Storage::disk('public')->path($relativePath);

            if (! empty($userAccount->profile_picture_path)) {
                Storage::disk('public')->delete($userAccount->profile_picture_path);
            }

            $imgResized->save($absolutePath);

            $userAccount->update([
                'profile_picture_path' => $relativePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully.',
                'profile_picture_url' => asset('storage/'.$relativePath),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the image.',
            ], 500);
        }
    }
}
