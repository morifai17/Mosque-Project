<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المعلمين - لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .teacher-card {
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .teacher-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
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

        /* تعديلات البوتستراب لتتناسب مع التصميم */
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background-color: #4f46e5;
            color: white;
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
            <div class="nav-item delayed-1">
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
                    <div class="nav-item delayed-3 active-nav">
                        <a href="{{ route('dashboard.teacher') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المعلمين</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nav-item delayed-4">
                <a href="{{ route('dashboard.products') }}">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
            </div>

            <div class="nav-item delayed-5">
                <a href="{{ route('dashboard.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>الفئات</span>
                </a>
            </div>

            <div class="nav-item delayed-6">
                <a href="{{ route('dashboard.coupons') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>الكوبونات</span>
                </a>
            </div>

            <div class="nav-item delayed-7">
                <a href="{{ route('dashboard.offers') }}">
                    <i class="fas fa-percentage"></i>
                    <span>العروض</span>
                </a>
            </div>

            <div class="nav-item delayed-8">
                <a href="{{ route('dashboard.order') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
            </div>

            {{-- <div class="nav-item delayed-9">
                <a href="{{ route('dashboard.QuranCycle') }}">
                    <i class="fas fa-book-quran"></i>
                    <span>دورات القرآن</span>
                </a>
            </div> --}}

            <div class="nav-item delayed-10 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-graduation-cap"></i>
                    <span>المحتوى التعليمي</span>
                </a>
                <div class="submenu pl-4">
                    {{-- <div class="nav-item">
                        <a href="{{ route('dashboard.students-content') }}">
                            <i class="fas fa-book-reader"></i>
                            <span>محتويات الطلاب</span>
                        </a>
                    </div> --}}
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
        <div class="content-card p-6">
            <h1 class="page-title text-2xl font-bold text-gray-800">👨‍🏫 إدارة المعلمين</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md flex-1 mr-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                        </div>
                        <div class="mr-3">
                            <p class="text-sm text-blue-700">
                                يمكنك إدارة المعلمين والطلاب من خلال هذه الصفحة. إضافة، تعديل أو حذف المعلمين والطلاب.
                            </p>
                        </div>
                    </div>
                </div>

                <button class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fas fa-user-plus ml-2"></i> إضافة طالب
                </button>
            </div>

            <!-- أزرار التبويب -->
            <div class="flex space-x-2 space-x-reverse mb-6">
                <button class="tab-button active" data-tab="students-tab">
                    <i class="fas fa-user-graduate ml-2"></i> قائمة الطلاب
                </button>
                <button class="tab-button" data-tab="points-tab">
                    <i class="fas fa-star ml-2"></i> إدارة النقاط
                </button>
            </div>

            <!-- محتوى التبويب: قائمة الطلاب -->
            <div id="students-tab" class="tab-content active">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4 space-x-reverse">
                        <div class="flex-1">
                            <input type="text" id="search-input" class="form-control" placeholder="ابحث باسم الطالب أو رقم الهاتف...">
                        </div>
                        <div class="w-full md:w-64">
                            <select id="circle-filter" class="form-control">
                                <option value="">جميع حلقات القرآن</option>
                                <!-- سيتم ملء هذا من خلال JavaScript -->
                            </select>
                        </div>
                        <button class="btn bg-blue-500 hover:bg-blue-600 text-white" id="search-btn">
                            <i class="fas fa-search ml-2"></i> بحث
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="students-container">
                    <div class="col-span-full text-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                        <p class="mt-4 text-gray-600">جاري تحميل الطلاب...</p>
                    </div>
                </div>
            </div>

            <!-- محتوى التبويب: إدارة النقاط -->
            <div id="points-tab" class="tab-content">
                <div class="bg-white p-5 rounded-lg shadow mb-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">إدارة نقاط الطلاب</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">اختر الطالب</label>
                            <select class="form-control" id="student-select">
                                <option value="">-- اختر الطالب --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">عدد النقاط</label>
                            <input type="number" class="form-control" id="points-input" placeholder="عدد النقاط">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">سبب التعديل</label>
                        <input type="text" class="form-control" id="reason-input" placeholder="سبب تعديل النقاط">
                    </div>

                    <button class="btn bg-blue-500 hover:bg-blue-600 text-white" id="update-points-btn">
                        <i class="fas fa-save ml-2"></i> تحديث النقاط
                    </button>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">سجل النقاط</h3>
                    <div id="points-history-container">
                        <div class="text-center py-8">
                            <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">اختر طالباً لعرض سجل النقاط</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal إضافة طالب -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="addStudentForm" class="modal-content">
                @csrf
                <div class="modal-header bg-blue-500 text-white">
                    <h5 class="modal-title">➕ إضافة طالب جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">حلقة القرآن</label>
                        <select class="form-control" name="quran_circle" id="circle-select" required>
                            <option value="">-- اختر حلقة القرآن --</option>
                            <!-- سيتم ملء هذا من خلال JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">اسم الطالب</label>
                        <input class="form-control" name="student_name" placeholder="اسم الطالب" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input class="form-control" name="phone_number" placeholder="رقم الهاتف" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_registered" id="is_registered" value="1">
                            <label class="form-check-label" for="is_registered">
                                مسجل في النظام
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
// المتغيرات العامة
let students = [];
let circles = [];

// دالة لتحميل حلقات القرآن الخاصة بالمعلم
async function loadCircles() {
    try {
        console.log('جاري تحميل حلقات القرآن...');
        const response = await fetch('/teacher/getTeacherCircles');

        if (!response.ok) {
            throw new Error(`خطأ في الشبكة: ${response.status}`);
        }

        const data = await response.json();
        console.log('استجابة الحلقات:', data);

        if (data.success) {
            circles = data.circles || [];

            // ملء select حلقات القرآن في modal الإضافة
            const circleSelect = document.getElementById('circle-select');
            circleSelect.innerHTML = '<option value="">-- اختر حلقة القرآن --</option>';
            circles.forEach(circle => {
                circleSelect.innerHTML += `<option value="${circle.id}">${circle.title}</option>`;
            });

            // ملء select التصفية بحلقات القرآن
            const circleFilter = document.getElementById('circle-filter');
            circleFilter.innerHTML = '<option value="">جميع حلقات القرآن</option>';
            circles.forEach(circle => {
                circleFilter.innerHTML += `<option value="${circle.id}">${circle.title}</option>`;
            });

            console.log('تم تحميل الحلقات بنجاح:', circles.length);
        } else {
            console.error('Error loading circles:', data.message);
            // استخدام بيانات افتراضية في حالة الخطأ
            circles = [
                { id: 1, title: "حلقة القرآن الأولى" },
                { id: 2, title: "حلقة القرآن الثانية" }
            ];
            showTemporaryCircles();
        }
    } catch (error) {
        console.error('Error loading circles:', error);
        // استخدام بيانات افتراضية في حالة الخطأ
        circles = [
            { id: 1, title: "حلقة القرآن الأولى" },
            { id: 2, title: "حلقة القرآن الثانية" }
        ];
        showTemporaryCircles();
    }
}

// دالة لعرض الحلقات المؤقتة
function showTemporaryCircles() {
    const circleSelect = document.getElementById('circle-select');
    const circleFilter = document.getElementById('circle-filter');

    circleSelect.innerHTML = '<option value="">-- اختر حلقة القرآن --</option>';
    circleFilter.innerHTML = '<option value="">جميع حلقات القرآن</option>';

    circles.forEach(circle => {
        circleSelect.innerHTML += `<option value="${circle.id}">${circle.title}</option>`;
        circleFilter.innerHTML += `<option value="${circle.id}">${circle.title}</option>`;
    });
}

// دالة لتحميل الطلاب
// دالة لتحميل الطلاب
async function loadStudents(circleId = '', searchTerm = '') {
    const container = document.getElementById("students-container");
    container.innerHTML = `
        <div class="col-span-full text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
            <p class="mt-4 text-gray-600">جاري تحميل الطلاب...</p>
        </div>
    `;

    try {
        console.log('جاري تحميل الطلاب...', { circleId, searchTerm });

        // بناء query string للبحث والتصفية
        let url = '/teacher/getStudents';
        const params = new URLSearchParams();

        if (circleId) params.append('quran_circle_id', circleId);
        if (searchTerm) params.append('search', searchTerm);

        if (params.toString()) {
            url += '?' + params.toString();
        }

        console.log('URL المطلوب:', url);

        const response = await fetch(url);
        console.log('استجابة الخادم:', response);

        const data = await response.json();
        console.log('البيانات المستلمة:', data);

        if (data.success && data.students && data.students.length) {
            students = data.students;
            container.innerHTML = "";

            data.students.forEach(student => {
                const circle = circles.find(c => c.id == student.quran_circle) || { title: 'غير معروف' };

                container.innerHTML += `
                <div class="bg-white rounded-xl overflow-hidden shadow-md teacher-card">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 text-gray-800">${student.student_name}</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            <i class="fas fa-phone ml-2"></i> ${student.phone_number}
                        </p>
                        <p class="text-sm text-gray-600 mb-4">
                            <i class="fas fa-book-quran ml-2"></i> ${circle.title}
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm ${student.is_registered ? 'text-green-600' : 'text-yellow-600'}">
                                <i class="fas ${student.is_registered ? 'fa-check-circle' : 'fa-clock'} ml-1"></i>
                                ${student.is_registered ? 'مسجل في النظام' : 'غير مسجل'}
                            </span>
                            <button class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg delete-student-btn flex items-center text-sm" data-id="${student.id}">
                                <i class="fas fa-trash ml-1"></i> حذف
                            </button>
                        </div>
                    </div>
                </div>`;
            });

            // تفعيل أزرار الحذف
            attachDeleteButtons();

            // تحديث قائمة الطلاب في إدارة النقاط (الطلاب المسجلين فقط)
            updateStudentSelect(data.students.filter(s => s.is_registered));

        } else {
            container.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-user-graduate text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">${data.message || 'لا توجد طلاب'}</p>
                    <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        <i class="fas fa-user-plus ml-2"></i> إضافة طالب جديد
                    </button>
                </div>`;

            // مسح قائمة الطلاب في إدارة النقاط
            document.getElementById('student-select').innerHTML = '<option value="">-- اختر الطالب --</option>';
        }
    } catch (err) {
        console.error('خطأ في تحميل الطلاب:', err);
        container.innerHTML = `
            <div class="col-span-full text-center py-8">
                <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                <p class="text-red-600">فشل تحميل الطلاب: ${err.message}</p>
                <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" onclick="loadStudents()">
                    <i class="fas fa-refresh ml-2"></i> إعادة المحاولة
                </button>
            </div>`;
    }
}

// دالة لتحديث قائمة الطلاب في إدارة النقاط
function updateStudentSelect(registeredStudents) {
    const studentSelect = document.getElementById('student-select');
    studentSelect.innerHTML = '<option value="">-- اختر الطالب --</option>';

    if (registeredStudents.length === 0) {
        studentSelect.innerHTML += '<option value="" disabled>لا توجد طلاب مسجلين</option>';
        return;
    }

    registeredStudents.forEach(student => {
        studentSelect.innerHTML += `<option value="${student.id}">${student.student_name} - ${student.phone_number}</option>`;
    });
}

// إضافة طالب
document.getElementById("addStudentForm").addEventListener("submit", async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    try {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';
        submitBtn.disabled = true;

        const response = await fetch("/teacher/addStudent", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        });

        const data = await response.json();
        if(data.success) {
            alert("✅ تم إضافة الطالب بنجاح!");
            e.target.reset();
            bootstrap.Modal.getInstance(document.getElementById('addStudentModal')).hide();
            loadStudents();
        } else {
            alert("❌ فشل الإضافة: " + (data.message || 'خطأ غير معروف'));
        }
    } catch(err) {
        alert("⚠️ حدث خطأ أثناء الإضافة");
        console.error(err);
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

// ربط أزرار الحذف
function attachDeleteButtons() {
    document.querySelectorAll('.delete-student-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            if(confirm('هل أنت متأكد من حذف هذا الطالب؟')) {
                try {
                    const response = await fetch(`/teacher/deleteStudent?id=${id}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    });

                    const data = await response.json();
                    if(data.success) {
                        alert("✅ تم حذف الطالب بنجاح!");
                        loadStudents();
                    } else {
                        alert("❌ فشل الحذف: " + (data.message || 'خطأ غير معروف'));
                    }
                } catch(err) {
                    alert("⚠️ حدث خطأ أثناء الحذف");
                    console.error(err);
                }
            }
        });
    });
}

// تحديث نقاط الطالب
document.getElementById("update-points-btn").addEventListener("click", async () => {
    const studentId = document.getElementById("student-select").value;
    const pointsChange = document.getElementById("points-input").value;
    const reason = document.getElementById("reason-input").value;

    if (!studentId || !pointsChange || !reason) {
        alert("⚠️ يرجى ملء جميع الحقول");
        return;
    }

    try {
        const response = await fetch("/teacher/updateStudentPoints", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                student_id: studentId,
                points_change: parseInt(pointsChange),
                reason: reason
            })
        });

        const data = await response.json();
        if(data.success) {
            alert("✅ تم تحديث نقاط الطالب بنجاح!");
            document.getElementById("points-input").value = "";
            document.getElementById("reason-input").value = "";
            loadPointsHistory(studentId);
        } else {
            alert("❌ فشل التحديث: " + (data.message || 'خطأ غير معروف'));
        }
    } catch(err) {
        alert("⚠️ حدث خطأ أثناء التحديث");
        console.error(err);
    }
});

// تحميل سجل النقاط
async function loadPointsHistory(studentId) {
    try {
        const response = await fetch(`/teacher/myStudentsPoints?student_id=${studentId}`);
        const data = await response.json();

        const container = document.getElementById("points-history-container");

        if (data.success && data.students && data.students.length) {
            const student = data.students[0];
            let historyHTML = `
                <div class="mb-4">
                    <h4 class="font-semibold">الطالب: ${student.student_name}</h4>
                    <p class="text-gray-600">النقاط الحالية: ${student.current_points}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التغيير</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السبب</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تم بواسطة</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">`;

            student.points_history.forEach(history => {
                const changeClass = history.points_change > 0 ? 'text-green-600' : 'text-red-600';
                historyHTML += `
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap ${changeClass} font-semibold">${history.points_change > 0 ? '+' : ''}${history.points_change}</td>
                        <td class="px-4 py-2 whitespace-nowrap">${history.reason}</td>
                        <td class="px-4 py-2 whitespace-nowrap">${history.performed_by}</td>
                        <td class="px-4 py-2 whitespace-nowrap">${new Date(history.changed_at).toLocaleString('ar-SA')}</td>
                    </tr>`;
            });

            historyHTML += `</tbody></table></div>`;
            container.innerHTML = historyHTML;
        } else {
            container.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-info-circle text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">لا يوجد سجل نقاط لهذا الطالب</p>
                </div>`;
        }
    } catch (err) {
        console.error('Error loading points history:', err);
        document.getElementById("points-history-container").innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                <p class="text-red-600">فشل تحميل سجل النقاط</p>
            </div>`;
    }
}

// دوال مساعدة للواجهة
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('sidebar-open');
}

function toggleSubmenu(element) {
    element.classList.toggle('open');
    const submenu = element.querySelector('.submenu');
    submenu.classList.toggle('open');
}

// دالة لاختبار الاتصال بالخادم
async function testConnection() {
    try {
        const response = await fetch('/teacher/test');
        const data = await response.json();
        console.log('اختبار الاتصال:', data);
        return data.success;
    } catch (error) {
        console.error('فشل اختبار الاتصال:', error);
        return false;
    }
}
// تحميل البيانات عند فتح الصفحة
document.addEventListener('DOMContentLoaded', async function() {
    console.log('بدء تحميل الصفحة...');

    // اختبار الاتصال أولاً
    const isConnected = await testConnection();
    console.log('حالة الاتصال:', isConnected ? 'ناجح' : 'فاشل');

    if (!isConnected) {
        alert('⚠️ هناك مشكلة في الاتصال بالخادم. يرجى التحقق من اتصال الإنترنت.');
    }

    // تحميل حلقات القرآن أولاً
    await loadCircles();

    // ثم تحميل الطلاب
    await loadStudents();

    // إعداد التبويبات
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            this.classList.add('active');
            document.getElementById(this.dataset.tab).classList.add('active');
        });
    });

    // إعداد بحث الطلاب
    document.getElementById('search-btn').addEventListener('click', function() {
        const searchTerm = document.getElementById('search-input').value;
        const circleId = document.getElementById('circle-filter').value;
        loadStudents(circleId, searchTerm);
    });

    // عند تغيير الطالب في إدارة النقاط
    document.getElementById('student-select').addEventListener('change', function() {
        if (this.value) {
            loadPointsHistory(this.value);
        } else {
            document.getElementById("points-history-container").innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">اختر طالباً لعرض سجل النقاط</p>
                </div>`;
        }
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
