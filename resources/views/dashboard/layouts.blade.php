<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
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
            <h1 class="text-xl font-bold">مسجد الرحمن</h1>
        </div>
        <nav class="mt-6">
            <div class="nav-item delayed-1 active-nav">
                <a href="{{ route('dashboard.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المشرفين</span>
                </a>
            </div>

            <div class="nav-item delayed-2 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-users"></i>
                    <span>المستخدمين</span>
                </a>
                <div class="submenu pl-4">
                    <div class="nav-item">
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

            <div class="nav-item delayed-8">
                <a href="{{ route('dashboard.QuranCycle') }}">
                    <i class="fas fa-book-quran"></i>
                    <span>دورات القرآن</span>
                </a>
            </div>

            <div class="nav-item delayed-9 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-graduation-cap"></i>
                    <span>المحتوى التعليمي</span>
                </a>
                <div class="submenu pl-4">
                    <div class="nav-item">
                        <a href="{{ route('dashboard.students-content') }}">
                            <i class="fas fa-book-reader"></i>
                            <span>محتويات الطلاب</span>
                        </a>
                    </div>
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

    <!-- المحتوى -->
    <main class="flex-1 p-6">
        <div class="content-card p-6">
            <h1 class="page-title text-2xl font-bold text-gray-800">لوحة التحكم الرئيسية</h1>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm text-blue-700">
                            مرحباً بعودتك! لديك 5 طلبات جديدة تحتاج إلى المراجعة.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-lg mb-3 text-gray-800">إحصائيات سريعة</h3>
                    <ul class="space-y-2">
                        <li class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600"><i class="fas fa-users text-blue-500 ml-2"></i> إجمالي المستخدمين</span>
                            <span class="font-bold">1,248</span>
                        </li>
                        <li class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600"><i class="fas fa-shopping-cart text-green-500 ml-2"></i> الطلاب هذا الشهر</span>
                            <span class="font-bold">124</span>
                        </li>
                        <li class="flex justify-between items-center py-2">
                            <span class="text-gray-600"><i class="fas fa-book-open text-purple-500 ml-2"></i> دورات القرآن</span>
                            <span class="font-bold">18</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-lg mb-3 text-gray-800">النشاط الحديث</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-user-plus text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">طالب جديد انضم إلى دورة القرآن</p>
                                <p class="text-xs text-gray-500">منذ ساعتين</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">تم إنشاء طلب جديد #ORD-2059</p>
                                <p class="text-xs text-gray-500">منذ 5 ساعات</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-book text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">تم إضافة محتوى تعليمي جديد</p>
                                <p class="text-xs text-gray-500">منذ يوم واحد</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقات إحصائية -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow delayed-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">المستخدمين</p>
                        <h3 class="text-2xl font-bold text-gray-800">1,248</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 12% منذ الشهر الماضي</p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow delayed-2">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">المنتجات</p>
                        <h3 class="text-2xl font-bold text-gray-800">356</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-box-open text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 5% منذ الشهر الماضي</p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow delayed-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">الكوبونات</p>
                        <h3 class="text-2xl font-bold text-gray-800">48</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-red-500 mt-2"><i class="fas fa-arrow-down"></i> 3% منذ الشهر الماضي</p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow delayed-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">الإيرادات</p>
                        <h3 class="text-2xl font-bold text-gray-800">24.8K</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 18% منذ الشهر الماضي</p>
            </div>
        </div>
    </main>

    <script>
        // دالة لإظهار/إخفاء القائمة الجانبية في الهاتف
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        }

        // دالة لإظهار/إخفاء القوائم الفرعية
        function toggleSubmenu(element) {
            element.classList.toggle('open');
            const submenu = element.querySelector('.submenu');
            submenu.classList.toggle('open');
        }

        // إضافة تأثيرات عند التمرير
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.nav-item, .content-card').forEach(el => {
                observer.observe(el);
            });

            // تعطيل الانتقال إلى الروابط في القوائم التي تحتوي على قوائم فرعية
            document.querySelectorAll('.has-submenu > a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
        });
    </script>
</body>
</html>
