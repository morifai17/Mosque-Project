<?php

use App\Http\Controllers\CategoryDashboardController;
use App\Http\Controllers\CouponDashboardController;
use App\Http\Controllers\ProductDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\TeacherAuthController;

// الصفحة الرئيسية - توجيه إلى واجهة الدخول
Route::get('/', function () {
    return view('webpage.login');
})->name('home');

// واجهة الدخول
Route::get('/login', function () {
    return view('webpage.login');
})->name('login');

// تسجيل الدخول للطلاب
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login');

// تسجيل الدخول للمعلمين
Route::post('/teacher/login', [TeacherAuthController::class, 'login'])->name('teacher.login');

// تسجيل الطلاب الجدد
Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register');

// تسجيل المعلمين الجدد
Route::post('/teacher/register', [TeacherAuthController::class, 'register'])->name('teacher.register');

// جلب قائمة المعلمين (للعرض في dropdown عند تسجيل طالب جديد)
Route::get('/api/teachers', [TeacherAuthController::class, 'getTeachers'])->name('api.teachers');

// لوحة تحكم الطالب (محمية بال middleware)
Route::middleware(['student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    Route::get('/student/profile', [StudentAuthController::class, 'profile'])->name('student.profile');
    Route::post('/student/updateProfile', [StudentAuthController::class, 'updateProfile'])->name('student.profile.update');
    Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
});

// لوحة تحكم المعلم (محمية بال middleware)
Route::middleware(['teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');

    Route::get('/teacher/profile', [TeacherAuthController::class, 'profile'])->name('teacher.profile');
    Route::put('/teacher/profile', [TeacherAuthController::class, 'updateProfile'])->name('teacher.profile.update');
    Route::get('/teacher/students', [StudentAuthController::class, 'getStudentsByTeacher'])->name('teacher.students');
    Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');
});

// Routes للـ API (للاستخدام من قبل الواجهة)
Route::prefix('api')->group(function () {
    Route::post('/student/login', [StudentAuthController::class, 'login']);
    Route::get('/teacher/login', [TeacherAuthController::class, 'login']);
    Route::post('/student/register', [StudentAuthController::class, 'register']);
    Route::post('/teacher/register', [TeacherAuthController::class, 'register']);
    Route::get('/teachers', [TeacherAuthController::class, 'getTeachers']);

    // Routes محمية بـ API middleware
    Route::middleware(['student.auth'])->group(function () {
        Route::get('/student/profile', [StudentAuthController::class, 'Profile']);
        Route::post('/student/updateProfile', [StudentAuthController::class, 'updateProfile']);
    });

    Route::middleware(['teacher.auth'])->group(function () {
        Route::get('/teacher/profile', [TeacherAuthController::class, 'profile']);
        Route::put('/teacher/profile', [TeacherAuthController::class, 'updateProfile']);
        Route::get('/teacher/students', [StudentAuthController::class, 'getStudentsByTeacher']);
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
// Route::fallback(function () {
//     return redirect()->route('login');




Route::prefix('dashboard')->group(function () {

    Route::get('/admins', function () {
        return view('dashboard.admins');
    })->name('dashboard.admins');

    Route::get('/coupons', function () {
        return view('dashboard.coupons');
    })->name('dashboard.coupons');

    Route::get('/teacher', function () {
        return view('dashboard.teacher');
    })->name('dashboard.teacher');

    Route::get('/layouts', function () {
        return view('dashboard.layouts');
    })->name('dashboard.layouts');

    Route::get('/offers', function () {
        return view('dashboard.offers');
    })->name('dashboard.offers');

    Route::get('/order', function () {
        return view('dashboard.order');
    })->name('dashboard.order');

    Route::get('/products', function () {
        return view('dashboard.products');
    })->name('dashboard.products');

    Route::get('/quran-cycle', function () {
        return view('dashboard.QuranCycle');
    })->name('dashboard.quran');

    Route::get('/categories', function () {
        return view('dashboard.categories');
    })->name('dashboard.categories');

    Route::get('/users', function () {
        return view('dashboard.users');
    })->name('dashboard.users');
});


Route::prefix('dashboard/products')->group(function () {
    Route::get('/index', [ProductDashboardController::class, 'index']);
    Route::post('/store', [ProductDashboardController::class, 'create']);
    Route::get('', [ProductDashboardController::class, 'page'])->name('dashboard.products');
Route::put('/{id}', [ProductDashboardController::class, 'update'])->name('dashboard.products.update');
    Route::delete('/{id}', [ProductDashboardController::class,'destroy'])
        ->name('dashboard.products.destroy');
});


Route::prefix('dashboard/categories')->group(function () {
    // صفحة Blade لإدارة الفئات

    // العمليات عبر الـ Web (عادة تستخدم Form + Method POST/PUT/DELETE)
    Route::get('/index', [CategoryDashboardController::class, 'index'])->name('categories.index');        // عرض كل الفئات
    Route::post('/create', [CategoryDashboardController::class, 'create'])->name('categories.create');    // إنشاء فئة جديدة
    Route::get('/show/{id}', [CategoryDashboardController::class, 'show'])->name('categories.show');      // عرض فئة محددة
    Route::put('/update/{id}', [CategoryDashboardController::class, 'update'])->name('categories.update'); // تعديل فئة
    Route::delete('/destroy/{id}', [CategoryDashboardController::class, 'destroy'])->name('categories.destroy'); // حذف فئة
});


Route::prefix('dashboard/coupons')->group(function () {
    Route::get('/index', [CouponDashboardController::class, 'index']);       // عرض جميع الكوبونات
    Route::post('/create', [CouponDashboardController::class, 'create']);     // إنشاء كوبون جديد
    Route::get('/{id}', [CouponDashboardController::class, 'show']);    // عرض كوبون محدد
    Route::put('update/{id}', [CouponDashboardController::class, 'update']);  // تعديل كوبون
    Route::delete('/{id}', [CouponDashboardController::class, 'destroy']); // حذف كوبون
});
