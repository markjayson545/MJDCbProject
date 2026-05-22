<?php

namespace App\Libraries;

use App\Models\Course;
use App\Models\Degree;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class AdminExportLibrary
{
    /**
     * @var array<string, string>
     */
    private const DATASETS = [
        'students' => 'Students Report',
        'teachers' => 'Teachers Report',
        'courses' => 'Subjects Report',
        'degrees' => 'Degrees Report',
        'user-accounts' => 'User Accounts Report',
        'user-profiles' => 'User Profiles Report',
        'summary' => 'System Summary Report',
    ];

    /**
     * @return array<string, string>
     */
    public function datasets(): array
    {
        return self::DATASETS;
    }

    public function isSupported(string $dataset): bool
    {
        return array_key_exists($dataset, self::DATASETS);
    }

    public function title(string $dataset): string
    {
        return self::DATASETS[$dataset] ?? 'Report';
    }

    public function filename(string $dataset, string $extension): string
    {
        return $dataset.'-report.'.$extension;
    }

    /**
     * @return array<int, string>
     */
    public function headings(string $dataset): array
    {
        return match ($dataset) {
            'students' => ['Name', 'Contact Number', 'Email', 'Degree', 'Degree Subjects', 'Enrolled Courses', 'Linked Profile', 'Account Status'],
            'teachers' => ['Name', 'Contact Number', 'Email', 'Department', 'Assigned Courses', 'Account Status'],
            'courses' => ['Subject Title', 'Linked Degrees', 'Assigned Teachers', 'Student Count'],
            'degrees' => ['Degree Name', 'Linked Subjects', 'Student Count'],
            'user-accounts' => ['Username', 'Email', 'Role', 'Status', 'Linked Profile', 'Created At', 'Updated At'],
            'user-profiles' => ['Username', 'Linked Student', 'Created At', 'Updated At'],
            'summary' => ['Metric', 'Value'],
            default => [],
        };
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    public function rows(string $dataset): Collection
    {
        return match ($dataset) {
            'students' => $this->studentRows(),
            'teachers' => $this->teacherRows(),
            'courses' => $this->courseRows(),
            'degrees' => $this->degreeRows(),
            'user-accounts' => $this->userAccountRows(),
            'user-profiles' => $this->userProfileRows(),
            'summary' => $this->summaryRows(),
            default => collect(),
        };
    }

    /**
     * @return array{dataset: string, title: string, headings: array<int, string>, rows: Collection<int, array<int, mixed>>, generatedAt: \Illuminate\Support\Carbon}
     */
    public function viewData(string $dataset): array
    {
        return [
            'dataset' => $dataset,
            'title' => $this->title($dataset),
            'headings' => $this->headings($dataset),
            'rows' => $this->rows($dataset),
            'generatedAt' => now(),
        ];
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function studentRows(): Collection
    {
        return Student::query()
            ->with(['degree.courses', 'courses', 'userProfile', 'userAccount'])
            ->orderBy('lname')
            ->orderBy('fname')
            ->get()
            ->map(fn (Student $student): array => [
                $this->personName($student),
                $student->contactno,
                $student->email,
                $student->degree?->name ?? 'None',
                $this->titles($student->degree?->courses),
                $this->titles($student->courses),
                $student->userProfile?->username ?? 'None',
                $this->accountStatus($student->userAccount),
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function teacherRows(): Collection
    {
        return Teacher::query()
            ->with(['courses', 'userAccount'])
            ->orderBy('lname')
            ->orderBy('fname')
            ->get()
            ->map(fn (Teacher $teacher): array => [
                $this->personName($teacher),
                $teacher->contactno ?? 'None',
                $teacher->email ?? 'None',
                $teacher->department ?? 'None',
                $this->titles($teacher->courses),
                $this->accountStatus($teacher->userAccount),
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function courseRows(): Collection
    {
        return Course::query()
            ->with(['degrees', 'teachers'])
            ->withCount('students')
            ->orderBy('title')
            ->get()
            ->map(fn (Course $course): array => [
                $course->title,
                $this->names($course->degrees, 'name'),
                $course->teachers
                    ->map(fn (Teacher $teacher): string => $this->personName($teacher))
                    ->filter()
                    ->implode(', ') ?: 'None',
                $course->students_count,
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function degreeRows(): Collection
    {
        return Degree::query()
            ->with('courses')
            ->withCount('students')
            ->orderBy('name')
            ->get()
            ->map(fn (Degree $degree): array => [
                $degree->name,
                $this->titles($degree->courses),
                $degree->students_count,
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function userAccountRows(): Collection
    {
        return UserAccount::query()
            ->with(['student', 'teacher'])
            ->orderBy('role')
            ->orderBy('username')
            ->get()
            ->map(fn (UserAccount $userAccount): array => [
                $userAccount->username,
                $userAccount->email,
                ucfirst($userAccount->role),
                $userAccount->is_active ? 'Active' : 'Inactive',
                $this->linkedProfile($userAccount),
                $this->formatDate($userAccount->created_at),
                $this->formatDate($userAccount->updated_at),
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function userProfileRows(): Collection
    {
        return UserProfile::query()
            ->with('student')
            ->orderBy('username')
            ->get()
            ->map(fn (UserProfile $userProfile): array => [
                $userProfile->username,
                $userProfile->student ? $this->personName($userProfile->student) : 'None',
                $this->formatDate($userProfile->created_at),
                $this->formatDate($userProfile->updated_at),
            ]);
    }

    /**
     * @return Collection<int, array<int, mixed>>
     */
    private function summaryRows(): Collection
    {
        $courseEnrollmentCount = Student::query()->withCount('courses')->get()->sum('courses_count');
        $teacherAssignmentCount = Teacher::query()->withCount('courses')->get()->sum('courses_count');
        $degreeSubjectCount = Degree::query()->withCount('courses')->get()->sum('courses_count');

        return collect([
            ['Students', Student::query()->count()],
            ['Teachers', Teacher::query()->count()],
            ['Subjects', Course::query()->count()],
            ['Degrees', Degree::query()->count()],
            ['User Accounts', UserAccount::query()->count()],
            ['User Profiles', UserProfile::query()->count()],
            ['Course Enrollments', $courseEnrollmentCount],
            ['Teacher Assignments', $teacherAssignmentCount],
            ['Degree Subject Links', $degreeSubjectCount],
        ]);
    }

    private function accountStatus(?UserAccount $userAccount): string
    {
        if (! $userAccount instanceof UserAccount) {
            return 'No account';
        }

        return $userAccount->is_active ? 'Active' : 'Inactive';
    }

    private function linkedProfile(UserAccount $userAccount): string
    {
        if ($userAccount->student instanceof Student) {
            return 'Student - '.$this->personName($userAccount->student);
        }

        if ($userAccount->teacher instanceof Teacher) {
            return 'Teacher - '.$this->personName($userAccount->teacher);
        }

        return 'None';
    }

    private function personName(object $person): string
    {
        return trim($person->lname.', '.$person->fname.' '.($person->mname ?? ''));
    }

    private function titles(?EloquentCollection $items): string
    {
        return $this->names($items, 'title');
    }

    private function names(?EloquentCollection $items, string $attribute): string
    {
        if (! $items instanceof EloquentCollection || $items->isEmpty()) {
            return 'None';
        }

        return $items->pluck($attribute)->filter()->implode(', ') ?: 'None';
    }

    private function formatDate(mixed $value): string
    {
        return $value ? $value->format('Y-m-d H:i') : 'None';
    }
}
