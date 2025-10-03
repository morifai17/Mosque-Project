<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - مسجد الخانقية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transform: translateX(0);
            transition: transform 0.4s ease;
        }

        .sidebar:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }

        .nav-item {
            position: relative;
            border-radius: 0.5rem;
            margin: 0.5rem 1rem;
            overflow: hidden;
        }

        .nav-item:before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
            border-radius: 0.5rem;
        }

        .nav-item:hover:before {
            width: 100%;
        }

        .nav-item a {
            position: relative;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
        }

        .nav-item i {
            margin-left: 0.75rem;
            font-size: 1.2rem;
        }

        .nav-item:hover {
            transform: translateX(-5px);
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 1.5rem 1rem;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo i {
            margin-left: 0.75rem;
            font-size: 1.8rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            border-radius: 2px;
        }

        /* تأثيرات للهاتف */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 100;
                height: 100%;
            }

            .sidebar-open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 101;
                background: #4f46e5;
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
        }

        /* تأثيرات التحميل للعناصر */
        .delayed-1 { animation-delay: 0.1s; }
        .delayed-2 { animation-delay: 0.2s; }
        .delayed-3 { animation-delay: 0.3s; }
        .delayed-4 { animation-delay: 0.4s; }
        .delayed-5 { animation-delay: 0.5s; }
        .delayed-6 { animation-delay: 0.6s; }
        .delayed-7 { animation-delay: 0.7s; }
        .delayed-8 { animation-delay: 0.8s; }
        .delayed-9 { animation-delay: 0.9s; }
        .delayed-10 { animation-delay: 1.0s; }
        .delayed-11 { animation-delay: 1.1s; }

        /* تأثيرات النص */
        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .active-nav {
            background: rgba(255, 255, 255, 0.2);
        }

        .active-nav:before {
            width: 100%;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.open {
            max-height: 500px;
        }

        .has-submenu::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .has-submenu.open::after {
            transform: rotate(180deg);
        }

        /* تنسيقات خاصة بصفحة الطلاب */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .action-btn {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-row:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            opacity: 0;
            animation: modalAppear 0.3s ease forwards;
        }

        @keyframes modalAppear {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4f46e5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .toast {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast.success {
            background-color: #10B981;
        }

        .toast.error {
            background-color: #EF4444;
        }

        .toast.warning {
            background-color: #F59E0B;
        }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- زر القائمة للهاتف -->
    <button class="menu-toggle md:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- سايدبار -->
    <aside class="sidebar w-64 min-h-screen">
        <div class="logo">
            <i class="fas fa-mosque"></i>
            <h1 class="text-xl font-bold">مسجد الخانقية</h1>
        </div>
        <nav class="mt-6">
            <div class="nav-item delayed-1">
                <a href="{{ route('dashboard.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المشرفين</span>
                </a>
            </div>

            <div class="nav-item delayed-2 has-submenu open" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-users"></i>
                    <span>المستخدمين</span>
                </a>
                <div class="submenu pl-4 open">
                    <div class="nav-item active-nav">
                        <a href="{{ route('dashboard.users') }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>الطلاب</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('dashboard.teacher') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المعلمين</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nav-item delayed-3">
                <a href="{{ route('dashboard.products') }}">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
            </div>

            <div class="nav-item delayed-4">
                <a href="{{ route('dashboard.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>الفئات</span>
                </a>
            </div>

            <div class="nav-item delayed-5">
                <a href="{{ route('dashboard.coupons') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>الكوبونات</span>
                </a>
            </div>

            <div class="nav-item delayed-6">
                <a href="{{ route('dashboard.offers') }}">
                    <i class="fas fa-percentage"></i>
                    <span>العروض</span>
                </a>
            </div>

            <div class="nav-item delayed-7">
                <a href="{{ route('dashboard.order') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
            </div>

            <div class="nav-item delayed-9 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-graduation-cap"></i>
                    <span>المحتوى التعليمي</span>
                </a>
                <div class="submenu pl-4">
                    <!-- يمكن إضافة عناصر هنا -->
                </div>
            </div>
        </nav>

        <!-- معلومات المستخدم -->
        <div class="absolute bottom-0 w-full p-4 text-white border-t border-white/10">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div class="mr-3">
                    <p class="font-medium">اسم المستخدم</p>
                    <p class="text-sm text-white/70">مدير النظام</p>
                </div>
                <a href="#" class="text-white/70 hover:text-white ml-auto">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="flex-1 p-6">
        <!-- بطاقات الإحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="stats-card delayed-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80">إجمالي الطلاب</p>
                        <h3 class="text-2xl font-bold" id="totalStudents">0</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-white/70 mt-2"><i class="fas fa-arrow-up"></i> <span id="studentsChange">0</span> هذا الشهر</p>
            </div>

            <div class="stats-card delayed-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80">طلاب مسجلين</p>
                        <h3 class="text-2xl font-bold" id="registeredStudents">0</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-white/70 mt-2"><i class="fas fa-user-plus"></i> <span id="registeredChange">0</span> جديد</p>
            </div>

            <div class="stats-card delayed-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80">إجمالي النقاط</p>
                        <h3 class="text-2xl font-bold" id="totalPoints">0</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-coins text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-white/70 mt-2"><i class="fas fa-chart-line"></i> <span id="pointsChange">0</span> نقطة</p>
            </div>

            <div class="stats-card delayed-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80">نشطاء هذا الأسبوع</p>
                        <h3 class="text-2xl font-bold" id="activeStudents">0</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-white/70 mt-2"><i class="fas fa-fire"></i> <span id="activeChange">0</span> طالب</p>
            </div>
        </div>

        <!-- محتوى إدارة الطلاب -->
        <div class="content-card p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="page-title text-2xl font-bold text-gray-800">إدارة الطلاب</h1>
                    <p class="text-gray-600 mt-2">إدارة وتتبع جميع طلاب مسجد الخانقية</p>
                </div>
                <button onclick="openAddStudentModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg action-btn">
                    <i class="fas fa-user-plus ml-2"></i>
                    إضافة طالب جديد
                </button>
            </div>

            <!-- شريط البحث والإجراءات -->
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-4 rounded-lg mb-6 border border-gray-200">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="flex-1 w-full">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="ابحث بالاسم أو الهاتف..."
                                   class="w-full p-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="searchStudents()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg action-btn">
                            <i class="fas fa-search ml-2"></i>
                            بحث
                        </button>
                        <button onclick="exportStudents()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg action-btn">
                            <i class="fas fa-download ml-2"></i>
                            تصدير
                        </button>
                    </div>
                </div>
            </div>

            <!-- جدول الطلاب -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full bg-white">
                    <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                        <tr>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">الاسم</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">الهاتف</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">النقاط</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">الحالة</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">آخر نشاط</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-700 border-b">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable" class="divide-y divide-gray-200">
                        <!-- سيتم ملؤها بالبيانات -->
                    </tbody>
                </table>
            </div>

            <!-- حالة التحميل -->
            <div id="loading" class="text-center py-12">
                <div class="loader"></div>
                <p class="text-gray-600 mt-4">جاري تحميل بيانات الطلاب...</p>
            </div>

            <!-- حالة عدم وجود بيانات -->
            <div id="noData" class="text-center py-12 hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">لا توجد طلاب</h3>
                <p class="text-gray-500 mb-6">لم يتم إضافة أي طلاب إلى النظام بعد</p>
                <button onclick="openAddStudentModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                    <i class="fas fa-user-plus ml-2"></i>
                    إضافة طالب جديد
                </button>
            </div>

            <!-- الترقيم -->
            <div id="pagination" class="flex justify-between items-center mt-6 hidden">
                <div class="text-gray-600 text-sm">
                    عرض <span id="currentCount">0</span> من <span id="totalCount">0</span> طالب
                </div>
                <div class="flex gap-2">
                    <button onclick="previousPage()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        السابق
                    </button>
                    <button onclick="nextPage()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        التالي
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- نافذة إضافة طالب -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">إضافة طالب جديد</h3>
                <button onclick="closeAddStudentModal()" class="text-gray-500 hover:text-gray-700 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addStudentForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم الطالب *</label>
                    <input type="text" name="student_name" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="أدخل اسم الطالب الكامل">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف *</label>
                    <input type="tel" name="phone_number" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="05XXXXXXXX">
                </div>
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <input type="checkbox" name="is_registered" id="is_registered" class="ml-2 w-5 h-5 text-blue-600 rounded">
                    <label for="is_registered" class="text-sm text-gray-700 font-medium">تسجيل الطالب في النظام مباشرة</label>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeAddStudentModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-lg font-medium transition">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition">
                        <i class="fas fa-save ml-2"></i>
                        حفظ الطالب
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- نافذة إدارة النقاط -->
    <div id="pointsModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">إدارة نقاط الطالب</h3>
                <button onclick="closePointsModal()" class="text-gray-500 hover:text-gray-700 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="pointsForm" class="space-y-4">
                <input type="hidden" name="student_id" id="pointsStudentId">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-2" id="studentName">اسم الطالب</h4>
                    <p class="text-sm text-gray-600">النقاط الحالية: <span id="currentPoints" class="font-bold">0</span></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تغيير النقاط *</label>
                    <input type="number" name="points_change" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="أدخل قيمة التغيير (موجب أو سالب)">
                    <p class="text-xs text-gray-500 mt-1">استخدم الأرقام الموجبة للإضافة والسالبة للخصم</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">السبب *</label>
                    <input type="text" name="reason" required
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="سبب تغيير النقاط">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closePointsModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 rounded-lg font-medium transition">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition">
                        <i class="fas fa-coins ml-2"></i>
                        تحديث النقاط
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- منطقة الإشعارات -->
    <div id="toastContainer"></div>

     <script>
        // التصحيح الأساسي - استخدام المسارات الصحيحة
        const API_BASE = '/api/teacher';

        // متغير لتخزين بيانات الطلاب الحالية
        let currentStudents = [];

        // تهيئة الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            checkApiEndpoints();
            loadStudents();
            setupEventListeners();
        });

        // التحقق من توفر الـ API endpoints
       // تحديث دالة checkApiEndpoints
async function checkApiEndpoints() {
    const endpoints = [
        { url: '/api/teacher/getStudents', method: 'GET' },
        { url: '/api/teacher/addStudent', method: 'POST' },
        { url: '/api/teacher/updateStudentPoints', method: 'POST' },
        { url: '/api/teacher/deleteStudent', method: 'DELETE' },
        { url: '/api/teacher/myStudentsPoints', method: 'GET' }
    ];

    console.log('التحقق من توفر الـ API endpoints:');

    for (const endpoint of endpoints) {
        try {
            const response = await fetch(endpoint.url, {
                method: endpoint.method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            });

            const contentType = response.headers.get('content-type');

            if (response.status === 401) {
                console.log(`⚠️ ${endpoint.url} - يحتاج مصادقة (401)`);
            } else if (contentType && contentType.includes('application/json')) {
                console.log(`✅ ${endpoint.url} - متوفر`);
            } else {
                console.warn(`❌ ${endpoint.url} - غير متوفر أو يعيد HTML (${response.status})`);
            }
        } catch (error) {
            console.error(`❌ ${endpoint.url} - خطأ:`, error.message);
        }
    }
}

// تحديث دالة deleteStudent لاستخدام DELETE method
async function deleteStudent(studentId) {
    if (!confirm('هل تريد حذف هذا الطالب؟')) {
        return;
    }

    try {
        const response = await fetch(`${API_BASE}/deleteStudent?id=${studentId}`, {
            method: 'DELETE',
          headers: getAuthHeaders()
        });

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const textResponse = await response.text();
            console.error('الخادم يعيد HTML:', textResponse.substring(0, 200));
            throw new Error('الخادم يعيد بيانات غير صحيحة');
        }

        const result = await response.json();

        if (result.success) {
            showToast('تم حذف الطالب بنجاح', 'success');
            loadStudents();
        } else {
            showToast(result.message || 'فشل في حذف الطالب', 'error');
        }
    } catch (error) {
        console.error('خطأ في حذف الطالب:', error);
        showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
    }
}

// إضافة مصادقة للطلبات
function getAuthHeaders() {
    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        'X-Requested-With': 'XMLHttpRequest'
    };

    // إذا كنت تستخدم API tokens
    const token = localStorage.getItem('auth_token');
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    return headers;
}

// تحديث جميع الطلاب لاستخدام headers المصادقة
async function loadStudents() {
    showLoading();

    try {
        const response = await fetch(`${API_BASE}/getStudents`, {
            method: 'GET',
            headers: getAuthHeaders()
        });

        // ... باقي الكود بدون تغيير
    } catch (error) {
        console.error('خطأ في تحميل الطلاب:', error);
        showError('خطأ في تحميل البيانات: ' + error.message);
    }
}

async function addStudent(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = {
        student_name: formData.get('student_name'),
        phone_number: formData.get('phone_number'),
        is_registered: formData.get('is_registered') ? true : false,
        quran_circle: 1
    };

    try {
        const response = await fetch(`${API_BASE}/addStudent`, {
            method: 'POST',
            headers: getAuthHeaders(),
            body: JSON.stringify(data)
        });

        // ... باقي الكود بدون تغيير
    } catch (error) {
        console.error('خطأ في إضافة الطالب:', error);
        showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
    }
}

        function setupEventListeners() {
            document.getElementById('addStudentForm').addEventListener('submit', addStudent);
            document.getElementById('pointsForm').addEventListener('submit', updateStudentPoints);

            // إغلاق النوافذ عند الضغط خارجها
            window.addEventListener('click', function(event) {
                const addModal = document.getElementById('addStudentModal');
                const pointsModal = document.getElementById('pointsModal');

                if (event.target === addModal) {
                    closeAddStudentModal();
                }
                if (event.target === pointsModal) {
                    closePointsModal();
                }
            });
        }

     // تحميل الطلاب مع النقاط - محدث
// تحميل الطلاب - محدث
async function loadStudents() {
    showLoading();

    try {
        console.log('جاري جلب البيانات من:', `${API_BASE}/getStudents`);
        const response = await fetch(`${API_BASE}/getStudents`);

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('الخادم يعيد بيانات غير صحيحة (ليست JSON)');
        }

        if (!response.ok) {
            throw new Error(`خطأ HTTP: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        console.log('البيانات المستلمة:', data);

        if (data.success) {
            // البيانات تأتي مباشرة مع النقاط من جدول students
            currentStudents = data.students || [];

            // تأكد من أن كل طالب لديه حقل points
            currentStudents = currentStudents.map(student => ({
                ...student,
                points: student.points || 0 // إذا لم تكن النقاط موجودة، استخدم 0
            }));

            displayStudents(currentStudents);
            updateStats(currentStudents);
        } else {
            throw new Error(data.message || 'فشل في تحميل البيانات');
        }
    } catch (error) {
        console.error('خطأ في تحميل الطلاب:', error);
        showError('خطأ في تحميل البيانات: ' + error.message);
    }
}
// في دالة loadStudents بعد جلب البيانات
console.log('بيانات الطلاب مع النقاط:', currentStudents);
currentStudents.forEach(student => {
    console.log(`الطالب: ${student.student_name}, النقاط: ${student.points}, نوع النقاط: ${typeof student.points}`);
});

// تحديث نقاط الطالب - مبسط
async function updateStudentPoints(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const studentId = formData.get('student_id');
    const pointsChange = parseInt(formData.get('points_change'));
    const reason = formData.get('reason');

    const student = currentStudents.find(s => s.id == studentId);

    if (!student) {
        showToast('لم يتم العثور على بيانات الطالب', 'error');
        return;
    }

    const data = {
        student_id: studentId,
        points_change: pointsChange,
        reason: reason
    };

    console.log('بيانات التحديث:', data);

    try {
        const response = await fetch(`${API_BASE}/updateStudentPoints`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showToast('تم تحديث نقاط الطالب بنجاح', 'success');

            // تحديث النقاط محلياً باستخدام البيانات المرتجعة من السيرفر
            if (result.student) {
                updateLocalStudentData(studentId, result.student.points, true);
            } else {
                // إذا لم ترجع البيانات، قم بالتحديث الرياضي
                updateLocalStudentData(studentId, pointsChange, false);
            }

            closePointsModal();
        } else {
            showToast(result.message || 'فشل في تحديث النقاط', 'error');
        }

    } catch (error) {
        console.error('خطأ في تحديث النقاط:', error);
        showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
    }
}

// دالة مساعدة للتحديث المحلي
function updateLocalStudentData(studentId, pointsValue, isAbsolute = false) {
    const studentIndex = currentStudents.findIndex(s => s.id == studentId);
    if (studentIndex !== -1) {
        if (isAbsolute) {
            // القيمة المطلقة (مباشرة من السيرفر)
            currentStudents[studentIndex].points = pointsValue;
        } else {
            // إضافة أو طرح (للتحديث المحلي فقط)
            currentStudents[studentIndex].points = (currentStudents[studentIndex].points || 0) + pointsValue;
        }

        // تحديث الواجهة
        updateStudentPointsInUI(studentId, currentStudents[studentIndex].points);

        // تحديث الإحصائيات
        updateStats(currentStudents);

        console.log(`تم تحديث النقاط: ${currentStudents[studentIndex].points} للطالب ${studentId}`);
    }
}

// دالة جديدة لمعالجة النقاط
async function processStudentsWithPoints(students) {
    try {
        // جلب إجمالي النقاط لكل طالب
        const pointsResponse = await fetch(`${API_BASE}/myStudentsPoints`);

        if (pointsResponse.ok) {
            const pointsData = await pointsResponse.json();
            console.log('بيانات النقاط:', pointsData);

            if (pointsData.success && pointsData.points) {
                // دمج النقاط مع بيانات الطلاب
                return students.map(student => {
                    const studentPoints = pointsData.points.find(p => p.student_id === student.id);
                    return {
                        ...student,
                        points: studentPoints ? studentPoints.total_points : 0
                    };
                });
            }
        }
    } catch (error) {
        console.error('خطأ في جلب النقاط:', error);
    }

    // في حالة الخطأ، نعود للبيانات الأساسية
    return students.map(student => ({
        ...student,
        points: student.points || 0
    }));
}

      // عرض الطلاب - مصحح
function displayStudents(students) {
    const tableBody = document.getElementById('studentsTable');
    const noDataDiv = document.getElementById('noData');
    const paginationDiv = document.getElementById('pagination');

    hideLoading();

    if (!students || students.length === 0) {
        tableBody.innerHTML = '';
        noDataDiv.classList.remove('hidden');
        paginationDiv.classList.add('hidden');
        return;
    }

    noDataDiv.classList.add('hidden');
    paginationDiv.classList.remove('hidden');

    tableBody.innerHTML = students.map((student) => {
        const studentName = student.student_name || 'غير محدد';
        const phoneNumber = student.phone_number || 'غير محدد';
        const points = student.points || 0; // تأكد من وجود قيمة افتراضية
        const isRegistered = student.is_registered || false;
        const lastActivity = student.updated_at || student.created_at || 'غير محدد';
        const studentId = student.id;

        return `
            <tr class="table-row" data-student-id="${studentId}">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold ml-3">
                            ${studentName.charAt(0)}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">${studentName}</p>
                            <p class="text-sm text-gray-500">${phoneNumber}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-gray-900">${phoneNumber}</p>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 points-display">
                        <i class="fas fa-coins ml-1"></i>
                        ${points} <!-- تم التصحيح هنا -->
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${isRegistered ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                        <i class="fas ${isRegistered ? 'fa-check-circle' : 'fa-clock'} ml-1"></i>
                        ${isRegistered ? 'مسجل' : 'قيد التسجيل'}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    ${formatDate(lastActivity)}
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        ${isRegistered ? `
                        <button onclick="managePoints(${studentId}, '${studentName}', ${points})"
                                class="text-blue-600 hover:text-blue-900 transition" title="إدارة النقاط">
                            <i class="fas fa-coins"></i>
                        </button>
                        ` : ''}
                        <button onclick="editStudent(${studentId})"
                                class="text-green-600 hover:text-green-900 transition" title="تعديل">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteStudent(${studentId})"
                                class="text-red-600 hover:text-red-900 transition" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

        // إضافة طالب - مع معالجة أفضل للأخطاء
        async function addStudent(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                student_name: formData.get('student_name'),
                phone_number: formData.get('phone_number'),
                is_registered: formData.get('is_registered') ? true : false,
                quran_circle: 1
            };

            try {
                const response = await fetch(`${API_BASE}/addStudent`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(data)
                });

                // التحقق من نوع الاستجابة
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const textResponse = await response.text();
                    console.error('الخادم يعيد HTML بدلاً من JSON:', textResponse.substring(0, 200));
                    throw new Error('الخادم يعيد بيانات غير صحيحة');
                }

                const result = await response.json();

                if (result.success) {
                    showToast('تم إضافة الطالب بنجاح', 'success');
                    closeAddStudentModal();
                    loadStudents();
                } else {
                    showToast(result.message || 'فشل في إضافة الطالب', 'error');
                }
            } catch (error) {
                console.error('خطأ في إضافة الطالب:', error);
                showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
            }
        }

// تحديث نقاط الطالب - محدث
async function updateStudentPoints(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const studentId = formData.get('student_id');
    const pointsChange = parseInt(formData.get('points_change'));
    const reason = formData.get('reason');

    const student = currentStudents.find(s => s.id == studentId);

    if (!student) {
        showToast('لم يتم العثور على بيانات الطالب', 'error');
        return;
    }

    if (!student.is_registered) {
        showToast('لا يمكن تحديث نقاط طالب غير مسجل في النظام', 'error');
        return;
    }

    const data = {
        student_id: studentId,
        points_change: pointsChange,
        reason: reason
    };

    console.log('بيانات التحديث:', data);

    try {
        const response = await fetch(`${API_BASE}/updateStudentPoints`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(data)
        });

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const textResponse = await response.text();
            console.error('الخادم يعيد HTML:', textResponse.substring(0, 500));

            // حل بديل: تحديث محلي مع إعادة حساب النقاط
            updateLocalStudentPoints(studentId, pointsChange, reason);
            showToast('تم تحديث النقاط محلياً', 'warning');
            closePointsModal();
            return;
        }

        const result = await response.json();

        if (result.success) {
            showToast('تم تحديث نقاط الطالب بنجاح', 'success');
            closePointsModal();

            // إعادة تحميل البيانات للتأكد من المزامنة
            loadStudents();
        } else {
            showToast(result.message || 'فشل في تحديث النقاط', 'error');
        }

    } catch (error) {
        console.error('خطأ في تحديث النقاط:', error);

        // حل بديل في حالة الخطأ
        updateLocalStudentPoints(studentId, pointsChange, reason);
        showToast('تم تحديث النقاط محلياً بسبب خطأ في الخادم', 'warning');
        closePointsModal();
    }
}

// دالة مساعدة للتحديث المحلي للنقاط
function updateLocalStudentPoints(studentId, pointsChange, reason) {
    const studentIndex = currentStudents.findIndex(s => s.id == studentId);
    if (studentIndex !== -1) {
        // تحديث النقاط محلياً
        currentStudents[studentIndex].points = (currentStudents[studentIndex].points || 0) + pointsChange;

        // تحديث الواجهة
        updateStudentPointsInUI(studentId, currentStudents[studentIndex].points);

        // تحديث الإحصائيات
        updateStats(currentStudents);

        console.log(`تم تحديث النقاط محلياً: ${pointsChange} للطالب ${studentId}, السبب: ${reason}`);
    }
}



        // دالة مساعدة لتحديث الواجهة
        function updateStudentPointsInUI(studentId, newPoints) {
            const studentRow = document.querySelector(`tr[data-student-id="${studentId}"]`);
            if (studentRow) {
                const pointsElement = studentRow.querySelector('.points-display');
                if (pointsElement) {
                    pointsElement.innerHTML = `<i class="fas fa-coins ml-1"></i> ${newPoints}`;
                }
            }
            updateStats(currentStudents);
        }

        // حذف طالب - مع معالجة الأخطاء
        async function deleteStudent(studentId) {
            if (!confirm('هل تريد حذف هذا الطالب؟')) {
                return;
            }

            try {
                const response = await fetch(`${API_BASE}/deleteStudent?id=${studentId}`);

                // التحقق من نوع الاستجابة
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const textResponse = await response.text();
                    console.error('الخادم يعيد HTML:', textResponse.substring(0, 200));
                    throw new Error('الخادم يعيد بيانات غير صحيحة');
                }

                const result = await response.json();

                if (result.success) {
                    showToast('تم حذف الطالب بنجاح', 'success');
                    loadStudents();
                } else {
                    showToast(result.message || 'فشل في حذف الطالب', 'error');
                }
            } catch (error) {
                console.error('خطأ في حذف الطالب:', error);
                showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
            }
        }

        // دالة مساعدة للحصول على CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content ||
                   document.querySelector('input[name="_token"]')?.value ||
                   '';
        }

        // دوال المساعدة الأخرى تبقى كما هي
        function updateStats(students) {
            const totalStudents = students.length;
            const registeredStudents = students.filter(s => s.is_registered).length;
            const totalPoints = students.reduce((sum, student) => sum + (student.points || 0), 0);
            const activeStudents = students.filter(s => isRecentActivity(s.updated_at || s.created_at)).length;

            document.getElementById('totalStudents').textContent = totalStudents;
            document.getElementById('registeredStudents').textContent = registeredStudents;
            document.getElementById('totalPoints').textContent = totalPoints.toLocaleString();
            document.getElementById('activeStudents').textContent = activeStudents;
        }

        function formatDate(dateString) {
            try {
                if (!dateString) return 'غير محدد';
                return new Date(dateString).toLocaleDateString('ar-SA');
            } catch {
                return 'غير محدد';
            }
        }

        function isRecentActivity(dateString) {
            try {
                if (!dateString) return false;
                const activityDate = new Date(dateString);
                const weekAgo = new Date();
                weekAgo.setDate(weekAgo.getDate() - 7);
                return activityDate > weekAgo;
            } catch {
                return false;
            }
        }

        // دوال إدارة النوافذ المنبثقة
        function openAddStudentModal() {
            document.getElementById('addStudentModal').style.display = 'block';
        }

        function closeAddStudentModal() {
            document.getElementById('addStudentModal').style.display = 'none';
            document.getElementById('addStudentForm').reset();
        }

        function managePoints(studentId, studentName, currentPoints) {
            document.getElementById('pointsStudentId').value = studentId;
            document.getElementById('studentName').textContent = studentName;
            document.getElementById('currentPoints').textContent = currentPoints;
            document.getElementById('pointsModal').style.display = 'block';
        }

        function closePointsModal() {
            document.getElementById('pointsModal').style.display = 'none';
            document.getElementById('pointsForm').reset();
        }

        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('noData').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }

        function showError(message) {
            showToast(message, 'error');
            document.getElementById('noData').classList.remove('hidden');
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.getElementById('toastContainer').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // دوال التنقل والإضافية
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        }

        function toggleSubmenu(element) {
            element.classList.toggle('open');
            const submenu = element.querySelector('.submenu');
            submenu.classList.toggle('open');
        }

        function searchStudents() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            if (searchTerm) {
                showToast('سيتم تنفيذ البحث عن: ' + searchTerm, 'warning');
            } else {
                loadStudents();
            }
        }

        function exportStudents() {
            showToast('سيتم تصدير بيانات الطلاب', 'warning');
        }

        function editStudent(studentId) {
            showToast('سيتم تعديل الطالب رقم: ' + studentId, 'warning');
        }

        function previousPage() {
            showToast('الانتقال للصفحة السابقة', 'warning');
        }

        function nextPage() {
            showToast('الانتقال للصفحة التالية', 'warning');
        }
    </script>
</body>
</html>
