<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المعلم</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* تحسينات إضافية */
        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-success {
            background: linear-gradient(to right, #10b981, #059669);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-warning {
            background: linear-gradient(to right, #f59e0b, #d97706);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: linear-gradient(to right, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

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

        .data-table tr:hover {
            background-color: #f8fafc;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-container input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .alert-info {
            background-color: #dbeafe;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .alert-success {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .section-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            <div class="nav-item">
                <a href="{{ route('dashboard.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المشرفين</span>
                </a>
            </div>

            <div class="nav-item has-submenu" onclick="toggleSubmenu(this)">
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

            <div class="nav-item">
                <a href="{{ route('dashboard.products') }}">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>الفئات</span>
                </a>
            </div>

            <div class="nav-item active-nav">
                <a href="{{ route('dashboard.coupons') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>الكوبونات</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.offers') }}">
                    <i class="fas fa-percentage"></i>
                    <span>العروض</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.order') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
            </div>
        </nav>


        <!-- معلومات المستخدم -->
        <div class="absolute bottom-0 w-full p-4 text-white border-t border-white/10">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div class="mr-3">
                    <p class="font-medium">المعلم/أحمد</p>
                    <p class="text-sm text-white/70">معلم قرآن</p>
                </div>
                <button onclick="showLogoutModal()" class="btn-logout ml-auto">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- المحتوى -->
    <main class="flex-1 p-6">
        <div class="content-card">
            <h1 class="page-title">
                <i class="fas fa-chalkboard-teacher text-purple-500 ml-2"></i>
                لوحة تحكم المعلم
            </h1>

            <div class="alert alert-info">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="mr-3">
                    <p class="text-sm">
                        مرحباً بعودتك! يمكنك إدارة طلابك وتحديث نقاطهم من هنا.
                    </p>
                </div>
            </div>

            <!-- ✅ إضافة طالب -->
            <div class="section-card delayed-1">
                <h2 class="section-title">
                    <i class="fas fa-user-plus text-green-500"></i>
                    إضافة طالب جديد
                </h2>
                <form id="addStudentForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اسم الطالب</label>
                            <input type="text" name="student_name" placeholder="أدخل اسم الطالب" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                            <input type="text" name="phone_number" placeholder="أدخل رقم الهاتف" class="form-input" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID حلقة القرآن</label>
                            <input type="number" name="quran_circle" placeholder="أدخل ID الحلقة" class="form-input" required>
                        </div>
                        <div class="flex items-center">
                            <div class="checkbox-container">
                                <input type="checkbox" name="is_registered" id="is_registered">
                                <label for="is_registered" class="text-sm font-medium text-gray-700">مسجل بالنظام</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة طالب
                    </button>
                </form>
            </div>

            <!-- ✅ قائمة الطلاب -->
            <div class="section-card delayed-2">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="section-title">
                        <i class="fas fa-users text-blue-500"></i>
                        قائمة الطلاب
                    </h2>
                    <button onclick="getStudents()" class="btn btn-primary">
                        <i class="fas fa-sync-alt ml-2"></i>
                        تحديث القائمة
                    </button>
                </div>
                <div id="studentsContainer" class="bg-gray-50 p-4 rounded-lg text-center text-gray-500">
                    <i class="fas fa-users text-4xl mb-2 text-gray-300"></i>
                    <p>لا يوجد طلاب بعد</p>
                </div>
            </div>

            <!-- ✅ تحديث النقاط -->
            <div class="section-card delayed-3">
                <h2 class="section-title">
                    <i class="fas fa-star text-yellow-500"></i>
                    تحديث نقاط طالب
                </h2>
                <form id="updatePointsForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID الطالب</label>
                            <input type="number" name="student_id" placeholder="أدخل ID الطالب" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">تغيير النقاط (+/-)</label>
                            <input type="number" name="points_change" placeholder="أدخل قيمة التغيير" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">سبب التغيير</label>
                            <input type="text" name="reason" placeholder="أدخل سبب التغيير" class="form-input" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-edit ml-2"></i>
                        تحديث النقاط
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- نافذة تأكيد تسجيل الخروج -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="mb-4">
                <i class="fas fa-sign-out-alt text-4xl text-red-500 mb-3"></i>
                <h3 class="text-xl font-bold text-gray-800">تأكيد تسجيل الخروج</h3>
                <p class="text-gray-600 mt-2">هل أنت متأكد من أنك تريد تسجيل الخروج؟</p>
            </div>
            <div class="flex gap-3 justify-center">
                <button onclick="hideLogoutModal()" class="btn btn-primary flex-1">
                    <i class="fas fa-times ml-2"></i>
                    إلغاء
                </button>
                <button onclick="logout()" class="btn btn-danger flex-1">
                    <i class="fas fa-sign-out-alt ml-2"></i>
                    تسجيل الخروج
                </button>
            </div>
        </div>
    </div>

    <script>
        // دالة لإظهار/إخفاء القائمة الجانبية في الهاتف
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
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

            document.querySelectorAll('.nav-item, .content-card, .section-card').forEach(el => {
                observer.observe(el);
            });

            // تحميل الطلاب عند فتح الصفحة
            getStudents();
        });

        // المتغيرات العامة
        const baseUrl = "http://127.0.0.1:8000/api"; // ✅ المسار الأساسي
        const token = localStorage.getItem("auth_token") || "your_auth_token_here"; // توكن المعلم

        // ✅ إضافة طالب
        document.getElementById("addStudentForm").addEventListener("submit", function(e){
            e.preventDefault();
            let formData = new FormData(this);

            fetch(`${baseUrl}/teacher/addStudent`, {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                showAlert(data.message, 'success');
                document.getElementById("addStudentForm").reset();
                getStudents();
            })
            .catch(error => {
                showAlert('حدث خطأ أثناء إضافة الطالب', 'error');
                console.error('Error:', error);
            });
        });

        // ✅ جلب الطلاب
        function getStudents() {
            fetch(`${baseUrl}/teacher/getStudents`, {
                method: "GET",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    showAlert("خطأ في جلب بيانات الطلاب", 'error');
                    return;
                }

                if (data.students && data.students.length > 0) {
                    let html = `<div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="p-3">ID</th>
                                    <th class="p-3">الاسم</th>
                                    <th class="p-3">الهاتف</th>
                                    <th class="p-3">مسجل</th>
                                    <th class="p-3">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    data.students.forEach(s => {
                        html += `
                            <tr>
                                <td class="p-3 font-medium">${s.id}</td>
                                <td class="p-3">${s.student_name}</td>
                                <td class="p-3">${s.phone_number}</td>
                                <td class="p-3">${s.is_registered ? '<span class="text-green-600"><i class="fas fa-check-circle"></i> نعم</span>' : '<span class="text-red-600"><i class="fas fa-times-circle"></i> لا</span>'}</td>
                                <td class="p-3">
                                    <button onclick="deleteStudent(${s.id})" class="btn btn-danger py-1 px-3 text-sm">
                                        <i class="fas fa-trash ml-1"></i>
                                        حذف
                                    </button>
                                </td>
                            </tr>`;
                    });
                    html += "</tbody></table></div>";
                    document.getElementById("studentsContainer").innerHTML = html;
                } else {
                    document.getElementById("studentsContainer").innerHTML = `
                        <div class="bg-gray-50 p-8 rounded-lg text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-2 text-gray-300"></i>
                            <p>لا يوجد طلاب بعد</p>
                        </div>`;
                }
            })
            .catch(error => {
                showAlert('حدث خطأ أثناء جلب بيانات الطلاب', 'error');
                console.error('Error:', error);
            });
        }

        // ✅ حذف طالب
        function deleteStudent(id) {
            if (!confirm("هل أنت متأكد من حذف الطالب؟")) return;

            fetch(`${baseUrl}/teacher/deleteStudent?id=${id}`, {
                method: "DELETE",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                showAlert(data.message, 'success');
                getStudents();
            })
            .catch(error => {
                showAlert('حدث خطأ أثناء حذف الطالب', 'error');
                console.error('Error:', error);
            });
        }

        // ✅ تحديث نقاط الطالب
        document.getElementById("updatePointsForm").addEventListener("submit", function(e){
            e.preventDefault();
            let formData = new FormData(this);

            fetch(`${baseUrl}/teacher/updateStudentPoints`, {
                method: "PUT",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                showAlert(data.message, 'success');
                document.getElementById("updatePointsForm").reset();
            })
            .catch(error => {
                showAlert('حدث خطأ أثناء تحديث النقاط', 'error');
                console.error('Error:', error);
            });
        });

        // ✅ دالة لعرض التنبيهات
        function showAlert(message, type) {
            // إزالة أي تنبيهات سابقة
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            // إنشاء تنبيه جديد
            const alert = document.createElement('div');
            alert.className = `custom-alert alert alert-${type} fixed top-4 left-4 right-4 md:left-auto md:right-4 w-90 md:w-96 z-50`;
            alert.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} ${type === 'success' ? 'text-green-500' : type === 'error' ? 'text-red-500' : 'text-blue-500'} ml-2"></i>
                    <span class="flex-1">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(alert);

            // إزالة التنبيه تلقائياً بعد 5 ثوانٍ
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 5000);
        }

        // ✅ دوال تسجيل الخروج
        function showLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }

        function hideLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        async function logout() {
            try {
                // استخدام POST بدلاً من DELETE لتجنب خطأ 405
                const response = await fetch(`${baseUrl}/logout`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                // التحقق من حالة الاستجابة
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // حذف التوكن من localStorage
                    localStorage.removeItem('auth_token');

                    showAlert('تم تسجيل الخروج بنجاح', 'success');

                    // إعادة التوجيه إلى صفحة تسجيل الدخول بعد ثانيتين
                    setTimeout(() => {
                        window.location.href = '/dashboard/login';
                    }, 2000);
                } else {
                    showAlert('حدث خطأ أثناء تسجيل الخروج', 'error');
                }
            } catch (error) {
                console.error('Error during logout:', error);
                showAlert('حدث خطأ أثناء تسجيل الخروج', 'error');

                // في حالة فشل الطلب، نقوم بحذف التوكن وإعادة التوجيه مباشرة
                localStorage.removeItem('auth_token');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } finally {
                hideLogoutModal();
            }
        }

        // إغلاق نافذة تسجيل الخروج عند النقر خارجها
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutModal();
            }
        });
    </script>
</body>
</html>
