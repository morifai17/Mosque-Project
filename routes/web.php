<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthStudentController;
use App\Http\Controllers\AuthTeacherController;

// الصفحة الرئيسية - توجيه إلى واجهة الدخول
Route::get('/', function () {
    return view('webpage.login');
})->name('home');

// واجهة الدخول
Route::get('/login', function () {
    return view('webpage.login');
})->name('login');

// تسجيل الدخول للطلاب
Route::post('/student/login', [AuthStudentController::class, 'login'])->name('student.login');

// تسجيل الدخول للمعلمين
Route::post('/teacher/login', [AuthTeacherController::class, 'login'])->name('teacher.login');

// تسجيل الطلاب الجدد
Route::post('/student/register', [AuthStudentController::class, 'register'])->name('student.register');

// تسجيل المعلمين الجدد
Route::post('/teacher/register', [AuthTeacherController::class, 'register'])->name('teacher.register');

// جلب قائمة المعلمين (للعرض في dropdown عند تسجيل طالب جديد)
Route::get('/api/teachers', [AuthTeacherController::class, 'getAllTeachers'])->name('api.teachers');

// لوحة تحكم الطالب (محمية بال middleware)
Route::middleware(['student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    Route::get('/student/profile', [AuthStudentController::class, 'getProfile'])->name('student.profile');
    Route::put('/student/profile', [AuthStudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::post('/student/logout', [AuthStudentController::class, 'logout'])->name('student.logout');
});

// لوحة تحكم المعلم (محمية بال middleware)
Route::middleware(['teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');

    Route::get('/teacher/profile', [AuthTeacherController::class, 'getProfile'])->name('teacher.profile');
    Route::put('/teacher/profile', [AuthTeacherController::class, 'updateProfile'])->name('teacher.profile.update');
    Route::get('/teacher/students', [AuthStudentController::class, 'getStudentsByTeacher'])->name('teacher.students');
    Route::post('/teacher/logout', [AuthTeacherController::class, 'logout'])->name('teacher.logout');
});

// Routes للـ API (للاستخدام من قبل الواجهة)
Route::prefix('api')->group(function () {
    Route::post('/student/login', [AuthStudentController::class, 'login']);
    Route::post('/teacher/login', [AuthTeacherController::class, 'login']);
    Route::post('/student/register', [AuthStudentController::class, 'register']);
    Route::post('/teacher/register', [AuthTeacherController::class, 'register']);
    Route::get('/teachers', [AuthTeacherController::class, 'getAllTeachers']);

    // Routes محمية بـ API middleware
    Route::middleware(['student.auth'])->group(function () {
        Route::get('/student/profile', [AuthStudentController::class, 'getProfile']);
        Route::put('/student/profile', [AuthStudentController::class, 'updateProfile']);
    });

    Route::middleware(['teacher.auth'])->group(function () {
        Route::get('/teacher/profile', [AuthTeacherController::class, 'getProfile']);
        Route::put('/teacher/profile', [AuthTeacherController::class, 'updateProfile']);
        Route::get('/teacher/students', [AuthStudentController::class, 'getStudentsByTeacher']);
    });
});
Route::get('/', function () {
    return view('webpage.home');
})->name('home');

// صفحة تسجيل الدخول
Route::get('/login', function () {
    return view('webpage.login');
})->name('login');


Route::get('/products', function () {
    return view('webpage.product');
})->name('products');

Route::get('/my-orders', function () {
    return view('webpage.MyOrder');
})->name('my-orders');

Route::get('/wallet', function () {
    return view('webpage.Wallet');
})->name('wallet');

Route::get('/quran-cycle', function () {
    return view('webpage.QuranCycle');
})->name('quran-cycle');

Route::get('/offers', function () {
    return view('webpage.offer');
})->name('offers');

Route::get('/settings', function () {
    return view('webpage.setting');
})->name('settings');

// Route احتياطي لكل المسارات غير المعرفة - توجيه إلى Login
Route::fallback(function () {
    return redirect()->route('login');
});
