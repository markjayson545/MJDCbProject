<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Degree;
use App\Models\MaintenanceSetting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MaintenanceSetting::query()->firstOrCreate([]);

        $demoPassword = Hash::driver('bcrypt')->make('password123');

        UserAccount::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@admin.com',
                'password' => Hash::driver('bcrypt')->make('admin123'),
                'role' => 'admin',
                'is_active' => 1,
                'password_changed_at' => now(),
            ]
        );

        $degreeNames = [
            'Bachelor of Science in Information Technology',
            'Bachelor of Science in Computer Science',
            'Bachelor of Science in Information Systems',
            'Bachelor of Science in Data Science',
            'Bachelor of Science in Cybersecurity',
        ];

        $courseTitles = [
            'Web Systems and Technologies',
            'Database Management Systems',
            'Object-Oriented Programming',
            'Human Computer Interaction',
            'Data Structures and Algorithms',
            'Computer Networks',
            'Operating Systems',
            'Software Engineering',
            'Systems Analysis and Design',
            'Information Assurance and Security',
            'Data Analytics Fundamentals',
            'Machine Learning Concepts',
            'Cloud Computing',
            'Mobile Application Development',
            'Capstone Project Planning',
            'Discrete Mathematics',
            'Platform Technologies',
            'Enterprise Architecture',
            'Cybersecurity Operations',
            'IT Project Management',
        ];

        $degrees = collect($degreeNames)
            ->mapWithKeys(fn (string $name): array => [
                $name => Degree::query()->updateOrCreate(['name' => $name]),
            ]);

        $courses = collect($courseTitles)
            ->mapWithKeys(fn (string $title): array => [
                $title => Course::query()->updateOrCreate(['title' => $title]),
            ]);

        $courseIds = $courses->pluck('id')->values();

        $degrees->values()->each(function (Degree $degree, int $index) use ($courseIds): void {
            $degree->courses()->sync($courseIds->slice($index * 4, 4)->values()->all());
        });

        $studentNames = [
            ['Maria', 'Luz', 'Santos'],
            ['Juan', 'Miguel', 'Reyes'],
            ['Angela', 'Mae', 'Cruz'],
            ['Carlo', 'Jose', 'Garcia'],
            ['Bianca', 'Rose', 'Torres'],
            ['Paolo', 'Luis', 'Ramos'],
            ['Katrina', 'Ann', 'Flores'],
            ['Mark', 'Jayson', 'Dela Cruz'],
            ['Alexia', 'Marie', 'Cayabyab'],
            ['Adrian', 'Paul', 'Cabic'],
            ['Nicole', 'Faith', 'Aquino'],
            ['Joshua', 'Ian', 'Mendoza'],
            ['Patricia', 'Joy', 'Castillo'],
            ['Daniel', 'Earl', 'Villanueva'],
            ['Sofia', 'Grace', 'Morales'],
            ['Gabriel', 'John', 'Navarro'],
            ['Camille', 'Jane', 'Ortega'],
            ['Rafael', 'Bryan', 'Domingo'],
            ['Jasmine', 'Claire', 'Rivera'],
            ['Nathan', 'Kyle', 'Lim'],
            ['Hannah', 'Bea', 'Perez'],
            ['Christian', 'Noel', 'Tan'],
            ['Alyssa', 'Ruth', 'Gomez'],
            ['Jerome', 'Neil', 'Lopez'],
            ['Mikaela', 'Jean', 'Valdez'],
            ['Francis', 'Roy', 'Santiago'],
            ['Trisha', 'Anne', 'Bautista'],
            ['Cedric', 'James', 'Soriano'],
            ['Erika', 'Louise', 'Velasco'],
            ['Vince', 'Aaron', 'Gutierrez'],
            ['Rhea', 'Elaine', 'Mercado'],
            ['Kenneth', 'Mark', 'Padilla'],
            ['Leah', 'Therese', 'Marquez'],
            ['Marlon', 'Ace', 'Fernandez'],
            ['Andrea', 'Paige', 'Salazar'],
            ['Lester', 'Ivan', 'Aguilar'],
            ['Celine', 'Hope', 'Francisco'],
            ['Ronald', 'Keith', 'Bernardo'],
            ['Elaine', 'Pearl', 'Manalo'],
            ['Kevin', 'Sean', 'Robles'],
        ];

        foreach ($studentNames as $index => [$firstName, $middleName, $lastName]) {
            $studentNumber = $index + 1;
            $degree = $degrees->values()->get($index % $degrees->count());
            $username = sprintf('student%02d', $studentNumber);
            $email = sprintf('student%02d@example.com', $studentNumber);

            $userProfile = UserProfile::query()->updateOrCreate(
                ['username' => $username.'_profile'],
                ['password' => $demoPassword]
            );

            $userAccount = UserAccount::query()->updateOrCreate(
                ['username' => $username],
                [
                    'email' => $email,
                    'password' => $demoPassword,
                    'role' => 'student',
                    'is_active' => 1,
                    'password_changed_at' => now(),
                ]
            );

            $student = Student::query()->updateOrCreate(
                ['email' => $email],
                [
                    'fname' => $firstName,
                    'mname' => $middleName,
                    'lname' => $lastName,
                    'contactno' => sprintf('0917%07d', $studentNumber),
                    'description' => 'Demo student record for reports and dashboard testing.',
                    'degree_id' => $degree->id,
                    'user_account_id' => $userAccount->id,
                    'user_profile_id' => $userProfile->id,
                ]
            );

            $student->courses()->sync($degree->courses()->pluck('courses.id')->values()->all());
        }

        $teacherNames = [
            ['Elena', 'Marie', 'Valencia', 'Information Technology'],
            ['Ramon', 'Luis', 'Herrera', 'Computer Science'],
            ['Lourdes', 'Ann', 'Montemayor', 'Information Systems'],
            ['Victor', 'Noel', 'Del Rosario', 'Data Science'],
            ['Grace', 'Elaine', 'Buenaventura', 'Cybersecurity'],
            ['Allan', 'Miguel', 'Lazaro', 'Information Technology'],
            ['Monica', 'Claire', 'De Leon', 'Computer Science'],
            ['Edwin', 'James', 'Serrano', 'Information Systems'],
            ['Clarissa', 'Joy', 'Uy', 'Data Science'],
            ['Roberto', 'Paolo', 'Chua', 'Cybersecurity'],
        ];

        foreach ($teacherNames as $index => [$firstName, $middleName, $lastName, $department]) {
            $teacherNumber = $index + 1;
            $username = sprintf('teacher%02d', $teacherNumber);
            $email = sprintf('teacher%02d@example.com', $teacherNumber);

            $userAccount = UserAccount::query()->updateOrCreate(
                ['username' => $username],
                [
                    'email' => $email,
                    'password' => $demoPassword,
                    'role' => 'teacher',
                    'is_active' => 1,
                    'password_changed_at' => now(),
                ]
            );

            $teacher = Teacher::query()->updateOrCreate(
                ['email' => $email],
                [
                    'fname' => $firstName,
                    'mname' => $middleName,
                    'lname' => $lastName,
                    'contactno' => sprintf('0927%07d', $teacherNumber),
                    'department' => $department,
                    'description' => 'Demo teacher record for course assignments and exports.',
                    'user_account_id' => $userAccount->id,
                ]
            );

            $teacher->courses()->sync($courseIds->slice($index * 2, 2)->values()->all());
        }
    }
}
