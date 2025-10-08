<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الإدارة</title>
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

        /* تحسينات للجداول */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th {
            background-color: #f8fafc;
            padding: 0.75rem;
            text-align: right;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .data-table tr {
            opacity: 0;
            transform: translateX(20px);
            animation: slideInRight 0.5s ease forwards;
        }

        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .data-table tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 300px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .error-message {
            color: #dc2626;
            margin-bottom: 1rem;
            display: none;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* بطاقات الإحصائيات */
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stats-card.teachers {
            border-left-color: #3b82f6;
        }

        .stats-card.circles {
            border-left-color: #10b981;
        }

        .stats-card.points {
            border-left-color: #f59e0b;
        }

        .stats-card.students {
            border-left-color: #8b5cf6;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f4f6;
            border-radius: 50%;
            border-top-color: #4f46e5;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .section-title {
            position: relative;
            padding-right: 1rem;
            margin-bottom: 1.5rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
            border-radius: 2px;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
            cursor: pointer;
            z-index: 50;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .notification {
            position: fixed;
            top: 1rem;
            left: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            color: white;
            z-index: 1000;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background-color: #10b981;
        }

        .notification.error {
            background-color: #ef4444;
        }

        .refresh-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .refresh-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .refresh-btn:active {
            transform: scale(0.95);
        }

        .pulse-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            animation: pulse-dot 2s infinite;
            margin-left: 0.5rem;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.7; }
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
                {{-- <a href="{{ route('dashboard.QuranCycle') }}">
                    <i class="fas fa-book-quran"></i>
                    <span>دورات القرآن</span>
                </a> --}}
            </div>

            <div class="nav-item delayed-9 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-graduation-cap"></i>
                    <span>المحتوى التعليمي</span>
                </a>
                <div class="submenu pl-4">
                    <div class="nav-item">
                        {{-- <a href="{{ route('dashboard.students-content') }}">
                            <i class="fas fa-book-reader"></i>
                            <span>محتويات الطلاب</span>
                        </a> --}}
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
            <h1 class="page-title text-2xl font-bold text-gray-800">📋 لوحة تحكم الإدارة</h1>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm text-blue-700">
                            مرحباً بعودتك! يمكنك إدارة المعلمين والحلقات وسجل النقاط من هنا.
                            <span class="pulse-dot"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- بطاقات الإحصائيات -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stats-card teachers delayed-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">إجمالي المعلمين</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="teachersCount">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card circles delayed-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">إجمالي الحلقات</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="circlesCount">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-book-quran text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card points delayed-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">تغييرات النقاط</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="pointsCount">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card students delayed-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">الطلاب النشطين</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="studentsCount">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-user-graduate text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📌 المعلمين -->
            <section class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="section-title text-xl font-semibold text-gray-800">👨‍🏫 المعلمين</h2>
                    <button class="refresh-btn" onclick="loadTeachers()">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                </div>

                <input id="teacherSearch" type="text" placeholder="🔍 ابحث عن معلم..."
                    class="search-input">

                <div id="teachersError" class="error-message"></div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">الاسم</th>
                                <th class="p-3">رقم الهاتف</th>
                                <th class="p-3">الكود</th>
                                <th class="p-3">الحالة</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTable"></tbody>
                    </table>
                </div>
            </section>

            <!-- 📌 الحلقات -->
            <section class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="section-title text-xl font-semibold text-gray-800">📚 الحلقات</h2>
                    <button class="refresh-btn" onclick="loadCircles()">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                </div>

                <div id="circlesError" class="error-message"></div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="p-3">#</th>
                                <th class="p-3">اسم الحلقة</th>
                                <th class="p-3">استاذ الحلقة</th>
                                <th class="p-3">الحالة</th>
                            </tr>
                        </thead>
                        <tbody id="circlesTable"></tbody>
                    </table>
                </div>
            </section>

            <!-- 📌 سجل النقاط -->
            <section>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="section-title text-xl font-semibold text-gray-800">📊 سجل تغييرات النقاط</h2>
                    <button class="refresh-btn" onclick="loadPoints()">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                </div>

                <div id="pointsError" class="error-message"></div>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="p-3">الطالب</th>
                                <th class="p-3">التغيير</th>
                                <th class="p-3">السبب</th>
                                <th class="p-3">تم بواسطة</th>
                                <th class="p-3">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody id="pointsTable"></tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- زر الإجراءات العائمة -->
    <div class="floating-action" onclick="refreshAllData()">
        <i class="fas fa-sync-alt"></i>
    </div>

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

        // دالة لعرض الإشعارات
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} ml-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // دالة لتحديث كل البيانات
        function refreshAllData() {
            const floatingBtn = document.querySelector('.floating-action');
            floatingBtn.innerHTML = '<div class="loading-spinner"></div>';

            Promise.all([loadTeachers(), loadCircles(), loadPoints()])
                .then(() => {
                    floatingBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                    showNotification('تم تحديث جميع البيانات بنجاح!', 'success');
                })
                .catch(() => {
                    floatingBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
                    showNotification('حدث خطأ أثناء تحديث البيانات', 'error');
                });
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

            document.querySelectorAll('.nav-item, .content-card, .stats-card').forEach(el => {
                observer.observe(el);
            });

            // تعطيل الانتقال إلى الروابط في القوائم التي تحتوي على قوائم فرعية
            document.querySelectorAll('.has-submenu > a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            // تحميل البيانات
            refreshAllData();
        });

        // 📌 تحميل المعلمين
        async function loadTeachers(search = "") {
            try {
                let response = await fetch("/api/admin/teachers?search=" + search);
                let data = await response.json();
                console.log("Teachers API:", data);

                if (!data.success || !data.teachers) {
                    document.getElementById("teachersError").textContent = "⚠️ لم يتم العثور على معلمين.";
                    document.getElementById("teachersError").style.display = "block";
                    document.getElementById("teachersCount").textContent = "0";
                    return;
                }
                document.getElementById("teachersError").style.display = "none";
                document.getElementById("teachersCount").textContent = data.teachers.length;

                let tbody = document.getElementById("teachersTable");
                tbody.innerHTML = "";
                data.teachers.forEach((t, i) => {
                    const status = t.is_active ? "نشط" : "غير نشط";
                    const statusClass = t.is_active ? "text-green-600" : "text-red-600";

                    tbody.innerHTML += `
                        <tr class="border-t hover:bg-gray-50" style="animation-delay: ${i * 0.1}s">
                            <td class="p-3">${i + 1}</td>
                            <td class="p-3 font-medium">${t.first_name} ${t.last_name}</td>
                            <td class="p-3">${t.phone_number}</td>
                            <td class="p-3">${t.code}</td>
                            <td class="p-3"><span class="${statusClass}">${status}</span></td>
                        </tr>`;
                });
            } catch (err) {
                console.error("Error loading teachers:", err);
                document.getElementById("teachersError").textContent = "❌ خطأ في تحميل بيانات المعلمين.";
                document.getElementById("teachersError").style.display = "block";
                document.getElementById("teachersCount").textContent = "0";
            }
        }

        // 📌 تحميل الحلقات
        async function loadCircles() {
            try {
                let response = await fetch("/api/admin/quranCircles");
                let data = await response.json();
                console.log("Circles API:", data);

                if (!data.success || !data.circles) {
                    document.getElementById("circlesError").textContent = "⚠️ لا توجد حلقات.";
                    document.getElementById("circlesError").style.display = "block";
                    document.getElementById("circlesCount").textContent = "0";
                    return;
                }
                document.getElementById("circlesError").style.display = "none";
                document.getElementById("circlesCount").textContent = data.circles.length;

                let tbody = document.getElementById("circlesTable");
                tbody.innerHTML = "";
                data.circles.forEach((c, i) => {
                    tbody.innerHTML += `
                        <tr class="border-t hover:bg-gray-50" style="animation-delay: ${i * 0.1}s">
                            <td class="p-3">${i + 1}</td>
                            <td class="p-3 font-medium">${c.title}</td>
                            <td class="p-3">${c.teacher_name || "-"}</td>
                            <td class="p-3"><span class="text-green-600">نشطة</span></td>
                        </tr>`;
                });
            } catch (err) {
                console.error("Error loading circles:", err);
                document.getElementById("circlesError").textContent = "❌ خطأ في تحميل الحلقات.";
                document.getElementById("circlesError").style.display = "block";
                document.getElementById("circlesCount").textContent = "0";
            }
        }

        // 📌 تحميل سجل النقاط
        async function loadPoints() {
            try {
                let response = await fetch("/api/admin/pointsChanges");
                let data = await response.json();
                console.log("Points API:", data);

                if (!data.success || !data.history) {
                    document.getElementById("pointsError").textContent = "⚠️ لا يوجد سجل نقاط.";
                    document.getElementById("pointsError").style.display = "block";
                    document.getElementById("pointsCount").textContent = "0";
                    return;
                }
                document.getElementById("pointsError").style.display = "none";
                document.getElementById("pointsCount").textContent = data.history.length;

                let tbody = document.getElementById("pointsTable");
                tbody.innerHTML = "";
                data.history.forEach((p, i) => {
                    const pointsClass = p.points_change > 0 ? "text-green-600" : "text-red-600";
                    const pointsSign = p.points_change > 0 ? "+" : "";

                    tbody.innerHTML += `
                        <tr class="border-t hover:bg-gray-50" style="animation-delay: ${i * 0.1}s">
                            <td class="p-3 font-medium">${p.student_name || "-"}</td>
                            <td class="p-3 ${pointsClass} font-bold">${pointsSign}${p.points_change}</td>
                            <td class="p-3">${p.reason}</td>
                            <td class="p-3">${p.performed_by}</td>
                            <td class="p-3">${p.changed_at}</td>
                        </tr>`;
                });
            } catch (err) {
                console.error("Error loading points:", err);
                document.getElementById("pointsError").textContent = "❌ خطأ في تحميل سجل النقاط.";
                document.getElementById("pointsError").style.display = "block";
                document.getElementById("pointsCount").textContent = "0";
            }
        }

        // 📌 البحث عن معلمين
        document.getElementById("teacherSearch").addEventListener("input", e => {
            loadTeachers(e.target.value);
        });

        // تعيين عدد افتراضي للطلاب (يمكن استبداله ببيانات حقيقية)
        document.getElementById("studentsCount").textContent = "125";
    </script>
</body>
</html>
