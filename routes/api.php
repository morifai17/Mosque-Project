<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthTeacherController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes here are loaded by RouteServiceProvider inside "api" middleware
| group. You can add public or protected endpoints as needed.
|
*/




// ✅ مسار افتراضي لفحص المستخدم (يتطلب تسجيل دخول)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// ----------------- مسارات Admin -----------------
Route::prefix('admin')->group(function () {
    // التسجيل - إنشاء مشرف جديد
    Route::post('/register', [AdminAuthController::class, 'register']);

    // تسجيل الدخول
    Route::post('/login', [AdminAuthController::class, 'login']);

    // مجموعة Routes تتطلب مصادقة
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/profile', [AdminAuthController::class, 'getProfile']);
        Route::put('/profile', [AdminAuthController::class, 'updateProfile']);
    });
});

// ----------------- مسارات Teacher -----------------
Route::prefix('teacher')->group(function () {
    Route::post('/register', [AuthTeacherController::class, 'register']);
    Route::post('/login', [AuthTeacherController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthTeacherController::class, 'logout']);
        Route::get('/profile', [AuthTeacherController::class, 'getProfile']);
        Route::put('/profile', [AuthTeacherController::class, 'updateProfile']);
        Route::get('/all', [AuthTeacherController::class, 'getAllTeachers']);
        Route::get('/{id}', [AuthTeacherController::class, 'getTeacherById']);
    });
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

