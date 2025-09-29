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
        }

        body {
            background: #f5f7fa;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
        }

        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
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
    </style>
</head>
<body class="min-h-screen flex">
    <!-- سايدبار مبسط -->
    <aside class="sidebar w-64 min-h-screen text-white">
        <div class="p-4 border-b border-white/10">
            <h1 class="text-xl font-bold">مسجد الخانقية</h1>
        </div>
        <nav class="mt-4">
            <div class="p-4 hover:bg-white/10">
                <i class="fas fa-users ml-2"></i>
                إدارة الطلاب
            </div>
        </nav>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="flex-1 p-6">
        <div class="content-card p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">إدارة الطلاب</h1>
                <button onclick="openAddStudentModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-user-plus ml-2"></i>
                    إضافة طالب جديد
                </button>
            </div>

            <!-- شريط البحث -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <div class="flex gap-4">
                    <input type="text" id="searchInput" placeholder="ابحث بالاسم أو الهاتف..."
                           class="flex-1 p-2 border border-gray-300 rounded-lg">
                    <button onclick="searchStudents()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-search ml-2"></i>
                        بحث
                    </button>
                </div>
            </div>

            <!-- جدول الطلاب -->
            <div class="overflow-x-auto">
                <table class="w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right">الاسم</th>
                            <th class="px-6 py-3 text-right">الهاتف</th>
                            <th class="px-6 py-3 text-right">النقاط</th>
                            <th class="px-6 py-3 text-right">الحالة</th>
                            <th class="px-6 py-3 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTable">
                        <!-- سيتم ملؤها بالبيانات -->
                    </tbody>
                </table>
            </div>

            <!-- حالة التحميل -->
            <div id="loading" class="text-center py-8">
                <div class="loader"></div>
                <p class="text-gray-600 mt-2">جاري تحميل البيانات...</p>
            </div>

            <!-- حالة عدم وجود بيانات -->
            <div id="noData" class="text-center py-8 hidden">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-600">لا توجد طلاب للعرض</p>
            </div>
        </div>
    </main>

    <!-- نافذة إضافة طالب -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">إضافة طالب جديد</h3>
                <button onclick="closeAddStudentModal()" class="text-gray-500">✕</button>
            </div>
            <form id="addStudentForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم الطالب *</label>
                        <input type="text" name="student_name" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف *</label>
                        <input type="tel" name="phone_number" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_registered" id="is_registered" class="ml-2">
                        <label for="is_registered" class="text-sm text-gray-700">تسجيل الطالب في النظام</label>
                    </div>
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="button" onclick="closeAddStudentModal()" class="flex-1 bg-gray-300 py-2 rounded-lg">
                        إلغاء
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg">
                        إضافة الطالب
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- نافذة إدارة النقاط -->
    <div id="pointsModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">إدارة نقاط الطالب</h3>
                <button onclick="closePointsModal()" class="text-gray-500">✕</button>
            </div>
            <form id="pointsForm">
                <input type="hidden" name="student_id" id="pointsStudentId">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تغيير النقاط *</label>
                        <input type="number" name="points_change" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">السبب *</label>
                        <input type="text" name="reason" required class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="button" onclick="closePointsModal()" class="flex-1 bg-gray-300 py-2 rounded-lg">
                        إلغاء
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg">
                        تحديث النقاط
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // التصحيح الأساسي - استخدام المسارات الصحيحة
        const API_BASE = '/api/teacher'; // أو المسار الصحيح لتطبيقك

        // تهيئة الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            loadStudents();
            setupEventListeners();
        });

        function setupEventListeners() {
            document.getElementById('addStudentForm').addEventListener('submit', addStudent);
            document.getElementById('pointsForm').addEventListener('submit', updateStudentPoints);
        }

        // تحميل الطلاب - إصدار مبسط
      // تحميل الطلاب - مع تصحيح الأخطاء
async function loadStudents() {
    showLoading();

    try {
        console.log('جاري جلب البيانات من:', `${API_BASE}/getStudents`);
        const response = await fetch(`${API_BASE}/getStudents`);
        console.log('حالة الاستجابة:', response.status, response.statusText);

        if (!response.ok) {
            throw new Error(`خطأ HTTP: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        console.log('البيانات الخام من الخادم:', data);

        // تحقق من هيكل البيانات
        if (data.success) {
            console.log('عدد الطلاب:', data.students ? data.students.length : 0);
            console.log('العينة الأولى من البيانات:', data.students ? data.students[0] : 'لا توجد بيانات');

            displayStudents(data.students || []);
        } else {
            console.error('الخادم لم يعد بنجاح:', data);
            showError('فشل في تحميل البيانات: ' + (data.message || 'سبب غير معروف'));
        }
    } catch (error) {
        console.error('خطأ تفصيلي في الاتصال:', error);
        showError('خطأ في الاتصال بالخادم: ' + error.message);
    }
}

        // عرض الطلاب - إصدار مبسط
    // عرض الطلاب - نسخة مرنة
function displayStudents(students) {
    const tableBody = document.getElementById('studentsTable');
    const noDataDiv = document.getElementById('noData');

    hideLoading();

    if (!students || students.length === 0) {
        console.log('لا توجد طلاب للعرض');
        tableBody.innerHTML = '';
        noDataDiv.classList.remove('hidden');
        return;
    }

    noDataDiv.classList.add('hidden');

    // استخدم أسماء الحقول المختلفة المحتملة
    tableBody.innerHTML = students.map((student, index) => {
        console.log(`الطالب ${index + 1}:`, student);

        // أسماء الحقول المحتملة للاسم
        const studentName = student.student_name || student.name || student.full_name ||
                           student.studentName || student.user_name || 'غير محدد';

        // أسماء الحقول المحتملة للهاتف
        const phoneNumber = student.phone_number || student.phone || student.mobile ||
                           student.phoneNumber || student.tel || 'غير محدد';

        // أسماء الحقول المحتملة للنقاط
        const points = student.points || student.point || student.score || student.points_count || 0;

        // حالة التسجيل
        const isRegistered = student.is_registered || student.registered || student.isRegistered || false;

        return `
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">${studentName}</td>
                <td class="px-6 py-4">${phoneNumber}</td>
                <td class="px-6 py-4">${points}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded ${isRegistered ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                        ${isRegistered ? 'مسجل' : 'غير مسجل'}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <button onclick="managePoints(${student.id || student.student_id || index})"
                            class="text-blue-600 hover:text-blue-900 ml-2">
                        النقاط
                    </button>
                    <button onclick="deleteStudent(${student.id || student.student_id || index})"
                            class="text-red-600 hover:text-red-900 ml-2">
                        حذف
                    </button>
                </td>
            </tr>
        `;
    }).join('');

    console.log('تم عرض', students.length, 'طالب');
}

        // إضافة طالب - إصدار مبسط
        async function addStudent(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                student_name: formData.get('student_name'),
                phone_number: formData.get('phone_number'),
                is_registered: formData.get('is_registered') ? true : false,
                quran_circle: 1 // افتراضي - تحتاج لتعديله
            };

            try {
                const response = await fetch(`${API_BASE}/addStudent`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // إذا كنت تستخدم Laravel
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('تم إضافة الطالب بنجاح');
                    closeAddStudentModal();
                    loadStudents();
                } else {
                    alert('خطأ: ' + (result.message || 'فشل في الإضافة'));
                }
            } catch (error) {
                alert('خطأ في الاتصال: ' + error.message);
            }
        }

        // دوال المساعدة المبسطة
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('noData').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }

        function showError(message) {
            alert(message);
            document.getElementById('noData').classList.remove('hidden');
        }

        function openAddStudentModal() {
            document.getElementById('addStudentModal').style.display = 'block';
        }

        function closeAddStudentModal() {
            document.getElementById('addStudentModal').style.display = 'none';
        }

        function managePoints(studentId) {
            document.getElementById('pointsStudentId').value = studentId;
            document.getElementById('pointsModal').style.display = 'block';
        }

        function closePointsModal() {
            document.getElementById('pointsModal').style.display = 'none';
        }

        async function updateStudentPoints(e) {
            e.preventDefault();
            // تنفيذ تحديث النقاط هنا
            alert('سيتم تنفيذ تحديث النقاط');
            closePointsModal();
        }

        async function deleteStudent(studentId) {
            if (confirm('هل تريد حذف هذا الطالب؟')) {
                try {
                    const response = await fetch(`${API_BASE}/deleteStudent?id=${studentId}`);
                    const result = await response.json();

                    if (result.success) {
                        alert('تم الحذف بنجاح');
                        loadStudents();
                    } else {
                        alert('خطأ في الحذف');
                    }
                } catch (error) {
                    alert('خطأ في الاتصال');
                }
            }
        }

        function searchStudents() {
            const searchTerm = document.getElementById('searchInput').value;
            // تنفيذ البحث هنا
            alert('سيتم تنفيذ البحث عن: ' + searchTerm);
        }
    </script>
</body>
</html>
