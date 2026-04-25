<?php

use App\Http\Controllers\Administrator\CoursesController;
use App\Http\Controllers\Administrator\DegreesController;
use App\Http\Controllers\Administrator\StudentsController;
use App\Http\Controllers\Administrator\UserProfileController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Student-management-only app:
// Route::get('/add', [CalculateController::class, 'add'])->name('calculate.add');
// Route::get('/subtract', [CalculateController::class, 'subtract'])->name('calculate.store');
// Route::get('/multiply', [CalculateController::class, 'multiply'])->name('calculate.multiply');
// Route::get('/divide', [CalculateController::class, 'divide'])->name('calculate.divide');
// Route::get('/modulo', [CalculateController::class, 'modulo'])->name('calculate.modulo');
// Route::resource('/clients', ClientController::class);
// Route::get('/welcome/{author}/{systemName}', [PSUController::class, 'welcome'])->name('welcome');
// Route::get('/mission', [PSUController::class, 'mission'])->name('mission');
// Route::get('/vision', [PSUController::class, 'vision'])->name('vision');
// Route::get('/EOMSPolicy', [PSUController::class, 'EOMSPolicy'])->name('EOMSPolicy');
// Route::get('/student/{name}/{course}', [PSUController::class, 'student'])->name('student');
// Route::resource('/students', StudentController::class);
// Route::get('/greetings', [ClientController::class, 'displayGreetings'])->name('greetings');
// Route::get('/about', function () {
//     return view('client.aboutUs');
// })->name('about');
// Route::get('/client-profile', function () {
//     return view('client.profile');
// })->name('client.profile');

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

Route::get('/', [UserController::class, 'login'])->name('login')->middleware('maintenance');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
Route::get('/logout', [UserController::class, 'logoutUser'])->name('logout');

Route::prefix('student')
    ->name('student.')
    ->middleware(['user.account', 'route.guard', 'user.account.role:student'])
    ->group(function () {
        Route::get('/password/update', [UserController::class, 'showUpdatePasswordForm'])
            ->name('password.edit')
            ->middleware('maintenance');
        Route::put('/password/update', [UserController::class, 'updatePassword'])
            ->name('password.update');
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware(['student.password.updated', 'maintenance']);
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['user.account', 'route.guard', 'user.account.role:admin'])
    ->group(function () {
        Route::get('/dashboard', [StudentsController::class, 'displayHome'])
            ->name('dashboard')
            ->middleware('maintenance');
        Route::get('/about', [StudentsController::class, 'displayAbout'])->name('about');
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');

        Route::resource('/students', StudentsController::class)->names('students');
        Route::resource('/degrees', DegreesController::class)->names('degrees');
        Route::resource('/courses', CoursesController::class)->names('courses');
        Route::resource('/user-profiles', UserProfileController::class)->names('user-profiles');
    });

Route::get('/register', [UserController::class, 'registerPage'])->name('register')->middleware('maintenance');
Route::post('/registerUser', [UserController::class, 'register'])->name('register.user')->middleware('maintenance');
