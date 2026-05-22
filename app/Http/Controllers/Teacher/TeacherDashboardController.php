<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\ProfilePictureUploadRequest;
use App\Libraries\ProfilePictureLibrary;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function uploadProfilePicture(ProfilePictureUploadRequest $request, ProfilePictureLibrary $profilePictures): JsonResponse
    {
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
            $relativePath = $profilePictures->upload($userAccount, $request->file('profile_picture'));

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully.',
                'profile_picture_url' => asset('storage/'.$relativePath),
            ]);
        } catch (\Throwable $throwable) {
            report($throwable);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process the image.',
            ], 500);
        }
    }
}
