<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\ProfilePictureUploadRequest;
use App\Libraries\ProfilePictureLibrary;
use App\Models\Student;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $studentId = $request->session()->get('student_id');

        $student = Student::query()
            ->with(['courses', 'degree.courses', 'userAccount'])
            ->findOrFail($studentId);

        $request->session()->put('student', $student);

        return view('student.student_dashboard')->with('student', $student);
    }

    public function uploadProfilePicture(ProfilePictureUploadRequest $request, ProfilePictureLibrary $profilePictures): JsonResponse
    {
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
