<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ✅ مسار افتراضي لفحص المستخدم (يتطلب تسجيل دخول)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// ----------------- AdminAuth -----------------

Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::get('/login', [AdminAuthController::class, 'login']);
    // مجموعة Routes تتطلب مصادقة
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/profile', [AdminAuthController::class, 'profile']);
        Route::post('/updateProfile', [AdminAuthController::class, 'updateProfile']);
    });
});



// ----------------- AdminDashboard -----------------

Route::prefix('admin')->group(function () {
    Route::post('/addTeacher', [AdminDashboardController::class, 'addTeacher']);
});



// ----------------- مسارات Teacher -----------------
Route::prefix('teacher')->group(function () {
    Route::post('/register', [TeacherAuthController::class, 'register']);
    Route::get('/login', [TeacherAuthController::class, 'login']);
    Route::get('/teachers', [TeacherAuthController::class, 'getTeachers']);

Route::middleware('auth:teacher')->group(function () {
        Route::get('/profile', [TeacherAuthController::class, 'profile']);
        Route::post('/updateProfile', [TeacherAuthController::class, 'updateProfile']);
        Route::get('/logout', [TeacherAuthController::class, 'logout']);
        
    });
});


//---------------------Teacher Dashboard-----------------------------
Route::prefix('teacher')->group(function () {
    Route::post('/addStudent', [TeacherDashboardController::class, 'addStudent']);
});


//----------------------Student Auth ---------------------------------
Route::prefix('student')->group(function () {
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::get('/login', [StudentAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/logout', [StudentAuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('/profile', [StudentAuthController::class, 'profile']);
    Route::middleware('auth:sanctum')->post('/updatProfile', [StudentAuthController::class, 'updateProfile']);

});



// ----------------- مسارات Dashboard للـ Products -----------------
Route::prefix('dashboard/products')->group(function () {
    Route::get('/', [ProductDashboardController::class, 'index']);
    Route::get('/create', [ProductDashboardController::class, 'create']);
    Route::post('/', [ProductDashboardController::class, 'store']);
    Route::get('/{id}', [ProductDashboardController::class, 'show']);
    Route::get('/{id}/edit', [ProductDashboardController::class, 'edit']);
    Route::put('/{id}', [ProductDashboardController::class, 'update']);
    Route::delete('/{id}', [ProductDashboardController::class, 'destroy']);
    Route::patch('/{id}/quantity', [ProductDashboardController::class, 'updateQuantity']);
    Route::get('/search/{query}', [ProductDashboardController::class, 'search']);
});

