<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentContoller;
use Illuminate\Support\Facades\Route;


Route::prefix('course-admin')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('index');
        })->name('index');
        Route::get('/students', [StudentContoller::class, 'index'])->name('students.index');
        Route::resource('courses', CourseController::class);
        Route::resource('courses.lessons', LessonController::class)->except(['show']);
    });

    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('/', [AuthController::class, 'login']);
});