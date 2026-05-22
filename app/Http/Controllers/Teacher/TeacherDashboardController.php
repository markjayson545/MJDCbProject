<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Archived\Controller;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TeacherDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $teacherId = $request->session()->get('teacher_id');

        $teacher = Teacher::query()
            ->with(['courses', 'userAccount'])
            ->findOrFail($teacherId);

        $courses = $teacher->courses()->withCount('students')->get();

        $courseCount = $courses->count();
        $studentCount = $courses->sum(function ($course) {
            return $course->students_count;
        });
        $avgClassSize = $courseCount > 0 ? round($studentCount / $courseCount, 1) : 0;

        $request->session()->put('teacher', $teacher);

        return view('teacher.teacher_dashboard', compact(
            'teacher',
            'courses',
            'courseCount',
            'studentCount',
            'avgClassSize'
        ));
    }

    public function uploadProfilePicture(Request $request): JsonResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $teacherId = $request->session()->get('teacher_id');
        $userAccountId = $request->session()->get('user_account_id');

        $teacher = Teacher::query()
            ->whereKey($teacherId)
            ->where('user_account_id', $userAccountId)
            ->with('userAccount')
            ->firstOrFail();

        $userAccount = $teacher->userAccount;

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
