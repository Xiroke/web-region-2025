<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;

Route::post('/regist', [AuthController::class, 'register']);
Route::post('/auth', [AuthController::class, 'authenticateApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'indexApi']);
    Route::get('/courses/{course}', [LessonController::class, 'indexApi']);
    Route::post('/courses/{course}/buy', [CourseController::class, 'buy']);
    Route::post('/payment-webhook', [CourseController::class, 'webhookPay']);
    Route::post('/orders/{courseStudent}', [CourseController::class, 'cancelPayment']);
    Route::get('/orders', [CourseController::class, 'indexMy']);
    Route::post('/create-sertificate', [CertificateController::class, 'store']);
    Route::post('/check-sertificate', [CertificateController::class, 'check']);
});
