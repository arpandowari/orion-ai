<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

// Health check for Railway
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'app' => 'ORION AI'], 200);
});

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Placement Series
Route::get('/placement', [PlacementController::class, 'index'])->name('placement.index');
Route::get('/placement/syllabus', [PlacementController::class, 'syllabus'])->name('placement.syllabus');
Route::post('/placement/enroll', [PlacementController::class, 'enroll'])->name('placement.enroll');
Route::get('/placement/success', [PlacementController::class, 'success'])->name('placement.success');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{id}/syllabus', [CourseController::class, 'syllabus'])->name('courses.syllabus');
Route::post('/video/{id}/complete', [CourseController::class, 'completeVideo'])->name('video.complete')->middleware('auth');

// Registration
Route::get('/register/{courseId}', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/register', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/registration/success', [RegistrationController::class, 'success'])->name('registration.success');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminCourseController::class, 'dashboard'])->name('admin.dashboard');
    
    // Analytics
    Route::get('/analytics', [App\Http\Controllers\AdminCourseController::class, 'analytics'])->name('admin.analytics');
    
    // Course Management
    Route::get('/courses/create', [App\Http\Controllers\AdminCourseController::class, 'createCourse'])->name('admin.courses.create');
    Route::post('/courses', [App\Http\Controllers\AdminCourseController::class, 'storeCourse'])->name('admin.courses.store');
    Route::get('/courses/{id}/edit', [App\Http\Controllers\AdminCourseController::class, 'editCourse'])->name('admin.courses.edit');
    Route::put('/courses/{id}', [App\Http\Controllers\AdminCourseController::class, 'updateCourse'])->name('admin.courses.update');
    Route::delete('/courses/{id}', [App\Http\Controllers\AdminCourseController::class, 'destroyCourse'])->name('admin.courses.destroy');
    Route::get('/courses/{id}/videos', [App\Http\Controllers\AdminCourseController::class, 'courseVideos'])->name('admin.courses.videos');
    
    // Video Management
    Route::get('/videos/create', [App\Http\Controllers\AdminCourseController::class, 'createVideo'])->name('admin.videos.create');
    Route::post('/videos', [App\Http\Controllers\AdminCourseController::class, 'storeVideo'])->name('admin.videos.store');
    Route::get('/videos/{id}/edit', [App\Http\Controllers\AdminCourseController::class, 'editVideo'])->name('admin.videos.edit');
    Route::put('/videos/{id}', [App\Http\Controllers\AdminCourseController::class, 'updateVideo'])->name('admin.videos.update');
    Route::delete('/videos/{id}', [App\Http\Controllers\AdminCourseController::class, 'destroyVideo'])->name('admin.videos.destroy');
    
    // Student Management
    Route::post('/registration/{id}/unlock', [App\Http\Controllers\AdminCourseController::class, 'unlockCourse'])->name('admin.unlockCourse');
    Route::post('/registration/{id}/toggle-lock', [App\Http\Controllers\AdminCourseController::class, 'toggleCourseLock'])->name('admin.toggleCourseLock');
    Route::post('/registration/{id}/status', [App\Http\Controllers\AdminCourseController::class, 'updateRegistrationStatus'])->name('admin.updateRegistrationStatus');
    Route::post('/placement/{id}/status', [App\Http\Controllers\AdminCourseController::class, 'updatePlacementStatus'])->name('admin.updatePlacementStatus');
    Route::get('/download/{type}/{id}', [App\Http\Controllers\AdminCourseController::class, 'downloadFile'])->name('admin.downloadFile');
    
    // Admin Management
    Route::get('/admins', [App\Http\Controllers\AdminManagementController::class, 'index'])->name('admin.admins.index');
    Route::get('/admins/create', [App\Http\Controllers\AdminManagementController::class, 'create'])->name('admin.admins.create');
    Route::post('/admins', [App\Http\Controllers\AdminManagementController::class, 'store'])->name('admin.admins.store');
    Route::get('/admins/{id}/edit', [App\Http\Controllers\AdminManagementController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admins/{id}', [App\Http\Controllers\AdminManagementController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admins/{id}', [App\Http\Controllers\AdminManagementController::class, 'destroy'])->name('admin.admins.destroy');
    Route::get('/admins/{id}/change-password', [App\Http\Controllers\AdminManagementController::class, 'showChangePasswordForm'])->name('admin.admins.change-password');
    Route::put('/admins/{id}/change-password', [App\Http\Controllers\AdminManagementController::class, 'changePassword'])->name('admin.admins.update-password');
    Route::post('/admins/{id}/send-verification', [App\Http\Controllers\AdminManagementController::class, 'sendVerificationEmail'])->name('admin.admins.send-verification');
    Route::get('/profile', [App\Http\Controllers\AdminManagementController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [App\Http\Controllers\AdminManagementController::class, 'updateProfile'])->name('admin.profile.update');
});

// Email verification route (outside auth middleware)
Route::get('/admin/verify-email/{id}/{token}', [App\Http\Controllers\AdminManagementController::class, 'verifyEmail'])->name('admin.verify-email');

// Admin Password Reset Routes (Public - No Auth Required)
Route::get('/admin/forgot-password', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'showForgotPasswordForm'])->name('admin.forgot-password');
Route::post('/admin/send-otp', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'sendOtp'])->name('admin.send-otp');
Route::get('/admin/verify-otp', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'showVerifyOtpForm'])->name('admin.verify-otp');
Route::post('/admin/verify-otp', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'verifyOtp'])->name('admin.verify-otp.submit');
Route::get('/admin/reset-password', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'showResetPasswordForm'])->name('admin.reset-password');
Route::post('/admin/reset-password', [App\Http\Controllers\Auth\AdminPasswordResetController::class, 'resetPassword'])->name('admin.reset-password.submit');

// Student Authentication Routes
Route::get('/student/login', [App\Http\Controllers\StudentAuthController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [App\Http\Controllers\StudentAuthController::class, 'login'])->name('student.login.submit');
Route::post('/student/logout', [App\Http\Controllers\StudentAuthController::class, 'logout'])->name('student.logout');

// Student Password Reset Routes
Route::get('/student/forgot-password', [App\Http\Controllers\StudentAuthController::class, 'showForgotPasswordForm'])->name('student.forgot-password');
Route::post('/student/send-otp', [App\Http\Controllers\StudentAuthController::class, 'sendOtp'])->name('student.send-otp');
Route::get('/student/verify-otp', [App\Http\Controllers\StudentAuthController::class, 'showVerifyOtpForm'])->name('student.verify-otp');
Route::post('/student/verify-otp', [App\Http\Controllers\StudentAuthController::class, 'verifyOtp'])->name('student.verify-otp.submit');
Route::get('/student/reset-password', [App\Http\Controllers\StudentAuthController::class, 'showResetPasswordForm'])->name('student.reset-password');
Route::post('/student/reset-password', [App\Http\Controllers\StudentAuthController::class, 'resetPassword'])->name('student.reset-password.submit');

// Student Dashboard Routes (protected by student.auth middleware)
Route::middleware(['student.auth'])->prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StudentAuthController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/profile', [App\Http\Controllers\StudentAuthController::class, 'profile'])->name('student.profile');
    Route::put('/profile', [App\Http\Controllers\StudentAuthController::class, 'updateProfile'])->name('student.profile.update');
});
