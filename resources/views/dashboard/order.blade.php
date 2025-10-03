<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات (الأدمن)</title>
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

        /* تحسينات خاصة بصفحة الطلبات */
        .order-card {
            border-left: 4px solid #4f46e5;
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-accepted {
            background-color: #d1fae5;
            color: #065f46;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-delivered {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .customer-info {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
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

            <div class="nav-item delayed-7 active-nav">
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
                    <!-- يمكن إضافة عناصر القائمة الفرعية هنا -->
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
            <h1 class="page-title text-2xl font-bold text-gray-800">إدارة الطلبات</h1>

            <!-- إحصائيات سريعة -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="stats-card bg-white rounded-xl p-5 shadow-md delayed-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">إجمالي الطلبات</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="totalOrders">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 12% منذ الشهر الماضي</p>
                </div>

                <div class="stats-card bg-white rounded-xl p-5 shadow-md delayed-2">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">طلبات قيد الانتظار</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="pendingOrders">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-red-500 mt-2"><i class="fas fa-arrow-up"></i> 5% منذ الأسبوع الماضي</p>
                </div>

                <div class="stats-card bg-white rounded-xl p-5 shadow-md delayed-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">طلبات مكتملة</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="completedOrders">0</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 18% منذ الشهر الماضي</p>
                </div>

                <div class="stats-card bg-white rounded-xl p-5 shadow-md delayed-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">إجمالي الإيرادات</p>
                            <h3 class="text-2xl font-bold text-gray-800" id="totalRevenue">0 ر.س</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 22% منذ الشهر الماضي</p>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="flex flex-wrap gap-4 mb-6">
                <button onclick="loadOrders()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-sync-alt ml-2"></i>
                    تحديث الطلبات
                </button>
                <button onclick="filterOrders('all')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-list ml-2"></i>
                    جميع الطلبات
                </button>
                <button onclick="filterOrders('pending')" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-clock ml-2"></i>
                    الطلبات المعلقة
                </button>
                <button onclick="filterOrders('accepted')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-check ml-2"></i>
                    الطلبات المقبولة
                </button>
                <button onclick="filterOrders('delivered')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-truck ml-2"></i>
                    الطلبات المسلمة
                </button>
            </div>

            <!-- حقل البحث -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="ابحث برقم الطلب أو اسم الطالب..."
                           class="w-full p-3 pr-12 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- مكان عرض الطلبات -->
            <div id="ordersContainer" class="space-y-4"></div>

            <!-- حالة التحميل -->
            <div id="loadingIndicator" class="hidden text-center py-8">
                <i class="fas fa-spinner fa-spin text-3xl text-blue-500 mb-4"></i>
                <p class="text-gray-600">جاري تحميل الطلبات...</p>
            </div>

            <!-- رسالة عدم وجود طلبات -->
            <div id="noOrdersMessage" class="hidden text-center py-8">
                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl text-gray-600 mb-2">لا توجد طلبات</h3>
                <p class="text-gray-500">لم يتم العثور على أي طلبات تطابق معايير البحث.</p>
            </div>
        </div>
    </main>

    <script>
        // ⚠️ لازم يكون عندك توكن الأدمن
        const token = localStorage.getItem("auth_token");
        let allOrders = [];
        let filteredOrders = [];

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

        // ✅ تحميل الطلبات
        async function loadOrders() {
            showLoading(true);

            try {
                const res = await fetch("/api/order/myOrders", {
                    headers: { "Authorization": "Bearer " + token }
                });
                const data = await res.json();

                const container = document.getElementById("ordersContainer");
                container.innerHTML = "";

                if (!data.success) {
                    container.innerHTML = `<div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                        <i class="fas fa-exclamation-circle ml-2"></i> ${data.message}
                    </div>`;
                    showNoOrdersMessage();
                    return;
                }

                allOrders = data.orders;
                filteredOrders = [...allOrders];

                updateStatistics();
                displayOrders(filteredOrders);

            } catch (error) {
                console.error("Error loading orders:", error);
                const container = document.getElementById("ordersContainer");
                container.innerHTML = `<div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                    <i class="fas fa-exclamation-circle ml-2"></i> حدث خطأ أثناء تحميل الطلبات
                </div>`;
            } finally {
                showLoading(false);
            }
        }

        // ✅ عرض الطلبات
        function displayOrders(orders) {
            const container = document.getElementById("ordersContainer");
            container.innerHTML = "";

            if (orders.length === 0) {
                showNoOrdersMessage();
                return;
            }

            hideNoOrdersMessage();

            orders.forEach(order => {
                const div = document.createElement("div");
                div.className = "order-card bg-white shadow rounded-lg p-5";

                const statusClass = getStatusClass(order.status);
                const statusText = getStatusText(order.status);

                // معلومات الطالب من العلاقة مع جدول students
                const student = order.student || {};

                div.innerHTML = `
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-4 mb-3">
                                <h3 class="text-lg font-bold text-gray-800">الطلب #${order.id}</h3>
                                <span class="${statusClass}">${statusText}</span>
                                <span class="text-sm text-gray-500">${formatDate(order.created_at)}</span>
                            </div>

                            <!-- معلومات الطالب -->
                            <div class="customer-info mb-4">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user-graduate ml-2"></i>
                                    معلومات الطالب
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    <div>
                                        <p class="text-gray-600 mb-1"><b>الاسم:</b> ${student.name || 'غير محدد'}</p>
                                        <p class="text-gray-600"><b>البريد الإلكتروني:</b> ${student.email || 'غير محدد'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1"><b>رقم الهاتف:</b> ${student.phone || 'غير محدد'}</p>
                                        <p class="text-gray-600"><b>العمر:</b> ${student.age || 'غير محدد'}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1"><b>المستوى:</b> ${student.level || 'غير محدد'}</p>
                                        <p class="text-gray-600"><b>الجنس:</b> ${student.gender || 'غير محدد'}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-gray-600 mb-1"><b>السعر الكلي:</b> ${order.total_price} ر.س</p>
                                    <p class="text-gray-600 mb-1"><b>السعر بعد الخصم:</b> ${order.final_price} ر.س</p>
                                    <p class="text-gray-600"><b>طريقة الدفع:</b> ${order.payment_method || 'غير محدد'}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 mb-1"><b>الكوبون:</b> ${order.coupon ? order.coupon.code : 'لا يوجد'}</p>
                                    <p class="text-gray-600"><b>نسبة الخصم:</b> ${order.coupon ? order.coupon.discount_percentage + '%' : '0%'}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="font-medium text-gray-700 mb-2"><i class="fas fa-boxes ml-2"></i> المنتجات:</p>
                                <ul class="bg-gray-50 rounded-lg p-3">
                                    ${order.products.map(p => `
                                        <li class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                            <div>
                                                <span class="font-medium">${p.name}</span>
                                                <span class="text-sm text-gray-500"> × ${p.quantity}</span>
                                            </div>
                                            <span class="font-medium">${p.subtotal} ر.س</span>
                                        </li>
                                    `).join("")}
                                </ul>
                            </div>
                        </div>

                        <!-- ✅ أزرار تغيير الحالة -->
                        <div class="flex flex-col gap-2 md:w-48">
                            <button onclick="updateOrderStatus(${order.id}, 'accepted')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center ${order.status === 'accepted' || order.status === 'delivered' ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${order.status === 'accepted' || order.status === 'delivered' ? 'disabled' : ''}>
                                <i class="fas fa-check ml-2"></i>
                                قبول الطلب
                            </button>
                            <button onclick="updateOrderStatus(${order.id}, 'rejected')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center ${order.status === 'rejected' || order.status === 'delivered' ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${order.status === 'rejected' || order.status === 'delivered' ? 'disabled' : ''}>
                                <i class="fas fa-times ml-2"></i>
                                رفض الطلب
                            </button>
                            <button onclick="updateOrderStatus(${order.id}, 'delivered')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center ${order.status === 'delivered' || order.status === 'rejected' ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${order.status === 'delivered' || order.status === 'rejected' ? 'disabled' : ''}>
                                <i class="fas fa-truck ml-2"></i>
                                تم التسليم
                            </button>
                            <button onclick="viewOrderDetails(${order.id})"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                                <i class="fas fa-eye ml-2"></i>
                                تفاصيل الطلب
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        // ✅ تحديث حالة الطلب
        async function updateOrderStatus(orderId, status) {
            if (!confirm(`هل أنت متأكد من تغيير حالة الطلب إلى "${getStatusText(status)}"؟`)) {
                return;
            }

            try {
                const res = await fetch("/api/order/updateOrderStatus", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + token,
                    },
                    body: JSON.stringify({ order_id: orderId, status }),
                });

                const data = await res.json();

                if (data.success) {
                    showNotification(`تم تحديث حالة الطلب #${orderId} بنجاح`, 'success');
                    loadOrders();
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error("Error updating order status:", error);
                showNotification('حدث خطأ أثناء تحديث حالة الطلب', 'error');
            }
        }

        // ✅ تصفية الطلبات حسب الحالة
        function filterOrders(status) {
            if (status === 'all') {
                filteredOrders = [...allOrders];
            } else {
                filteredOrders = allOrders.filter(order => order.status === status);
            }
            displayOrders(filteredOrders);
        }

        // ✅ البحث في الطلبات
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                if (searchTerm.length === 0) {
                    filteredOrders = [...allOrders];
                } else {
                    filteredOrders = allOrders.filter(order =>
                        order.id.toString().includes(searchTerm) ||
                        (order.student && order.student.name && order.student.name.toLowerCase().includes(searchTerm))
                    );
                }

                displayOrders(filteredOrders);
            });
        }

        // ✅ تحديث الإحصائيات
        function updateStatistics() {
            const totalOrders = allOrders.length;
            const pendingOrders = allOrders.filter(order => order.status === 'pending').length;
            const completedOrders = allOrders.filter(order => order.status === 'delivered').length;
            const totalRevenue = allOrders
                .filter(order => order.status === 'delivered')
                .reduce((sum, order) => sum + parseFloat(order.final_price || 0), 0);

            document.getElementById('totalOrders').textContent = totalOrders;
            document.getElementById('pendingOrders').textContent = pendingOrders;
            document.getElementById('completedOrders').textContent = completedOrders;
            document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2) + ' ر.س';
        }

        // ✅ الحصول على كلاس الحالة
        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'status-pending';
                case 'accepted': return 'status-accepted';
                case 'rejected': return 'status-rejected';
                case 'delivered': return 'status-delivered';
                default: return 'status-pending';
            }
        }

        // ✅ الحصول على نص الحالة
        function getStatusText(status) {
            switch(status) {
                case 'pending': return 'قيد الانتظار';
                case 'accepted': return 'مقبول';
                case 'rejected': return 'مرفوض';
                case 'delivered': return 'تم التسليم';
                default: return 'قيد الانتظار';
            }
        }

        // ✅ تنسيق التاريخ
        function formatDate(dateString) {
            if (!dateString) return 'غير محدد';
            const date = new Date(dateString);
            return date.toLocaleDateString('ar-SA');
        }

        // ✅ عرض تفاصيل الطلب
        function viewOrderDetails(orderId) {
            alert(`عرض تفاصيل الطلب #${orderId} - هذه الميزة قيد التطوير`);
            // يمكن استبدال هذا بتنفيذ عرض تفاصيل الطلب في نافذة منبثقة أو صفحة منفصلة
        }

        // ✅ إظهار/إخفاء مؤشر التحميل
        function showLoading(show) {
            const loadingIndicator = document.getElementById('loadingIndicator');
            if (show) {
                loadingIndicator.classList.remove('hidden');
            } else {
                loadingIndicator.classList.add('hidden');
            }
        }

        // ✅ إظهار/إخفاء رسالة عدم وجود طلبات
        function showNoOrdersMessage() {
            document.getElementById('noOrdersMessage').classList.remove('hidden');
        }

        function hideNoOrdersMessage() {
            document.getElementById('noOrdersMessage').classList.add('hidden');
        }

        // ✅ عرض الإشعارات
        function showNotification(message, type = 'info') {
            // إنشاء عنصر الإشعار
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' :
                           type === 'error' ? 'bg-red-500' :
                           'bg-blue-500';

            notification.className = `fixed top-4 left-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-0`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} ml-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // إخفاء الإشعار بعد 3 ثوانٍ
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // ✅ التهيئة عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();
            setupSearch();

            // إضافة تأثيرات عند التمرير
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
        });
    </script>
</body>
</html>
