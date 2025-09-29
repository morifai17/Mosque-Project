<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryDashboardController;
use App\Http\Controllers\CouponDashboardController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ✅ مسار افتراضي لفحص المستخدم (يتطلب تسجيل دخول)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products/getProducts', [ProductController::class, 'getProducts']);


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
    Route::get('/teachers', [AdmindashboardController::class, 'getTeachers']);
    Route::get('/quranCircles', [AdmindashboardController::class, 'getQuranCircles']);
    Route::get('/pointsChanges', [AdmindashboardController::class, 'pointsChanges']);


});



// ----------------- مسارات Teacher -----------------
Route::prefix('teacher')->group(function () {
    Route::post('/register', [TeacherAuthController::class, 'register']);
    Route::post('/login', [TeacherAuthController::class, 'login']);
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
    Route::get('/deleteStudent', [TeacherDashboardController::class, 'deleteStudent']);
    Route::get('/getStudents', [TeacherDashboardController::class, 'getStudents']);
    Route::post('/updateStudentPoints', [TeacherDashboardController::class, 'updateStudentPoints']);
    Route::get('/myStudentsPoints', [TeacherDashboardController::class, 'myStudentsPoints']);
    Route::get('/getTeacherCircles', [TeacherDashboardController::class, 'getTeacherCircles']);
});


//----------------------Student Auth ---------------------------------
Route::prefix('student')->group(function () {
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::get('/login', [StudentAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/logout', [StudentAuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('/profile', [StudentAuthController::class, 'profile']);
    Route::middleware('auth:sanctum')->get('/pointsHistory', [StudentAuthController::class, 'pointsHistory']);
    Route::middleware('auth:sanctum')->post('/updatProfile', [StudentAuthController::class, 'updateProfile']);

});

// ----------------- Cart -----------------
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/remove', [CartController::class, 'remove']);
    Route::get('/get', [CartController::class, 'get']);

});
// ----------------- مسارات Dashboard للـ Products -----------------
Route::prefix('dashboard/products')->group(function () {
    Route::get('/index', [ProductDashboardController::class, 'index']);
    Route::post('/create', [ProductDashboardController::class, 'create']);
    Route::get('/show/{id}', [ProductDashboardController::class, 'show']);
    Route::put('/update/{id}', [ProductDashboardController::class, 'update']);
    Route::delete('/destroy/{id}', [ProductDashboardController::class, 'destroy']);
});

Route::prefix('dashboard/categories')->group(function () {
    Route::post('/create', [CategoryDashboardController::class, 'create']);     // إنشاء فئة جديدة
    Route::get('/show/{id}', [CategoryDashboardController::class, 'show']);     // عرض فئة محددة
    Route::put('/update/{id}', [CategoryDashboardController::class, 'update']);  // تحديث فئة
    Route::delete('/destroy/{id}', [CategoryDashboardController::class, 'destroy']); // حذف فئة
});
Route::prefix('dashboard/coupons')->group(function () {
    Route::post('/create', [CouponDashboardController::class, 'create']);       // إنشاء كوبون جديد
    Route::get('/index', [CouponDashboardController::class, 'index']);       // عرض كوبون محدد
    Route::put('/update/{id}', [CouponDashboardController::class, 'update']);   // تحديث كوبون
    Route::delete('/destroy/{id}', [CouponDashboardController::class, 'destroy']); // حذف كوبون
});

// ----------------- Order -----------------
Route::prefix('order')->group(function () {
    Route::post('/save', [OrderController::class, 'save']);
    Route::get('/cancel', [OrderController::class, 'cancel']);
    Route::get('/myOrders', [OrderController::class, 'myOrders']);
    Route::post('/updateOrderStatus', [OrderController::class, 'updateOrderStatus']);

});
