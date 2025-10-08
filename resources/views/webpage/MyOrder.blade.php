<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="ordersApp()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي | مسجد الخانقية</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f9f2f3',
                            100: '#f2e4e6',
                            500: '#5C1F25', // الخمري الأساسي
                            600: '#4A191F',
                            700: '#3E1419',
                            800: '#2F0F13',
                            900: '#1F0A0D'
                        },
                        golden: {
                            100: '#f9f0d9',
                            300: '#E6C875',
                            400: '#D4AF37', // الذهبي الأساسي
                            500: '#C19C30',
                            600: '#A68528'
                        }
                    },
                    fontFamily: {
                        'arabic': ['Tajawal', 'ui-sans-serif', 'system-ui'],
                        'quranic': ['Scheherazade New', 'Tajawal', 'serif'],
                        'elegant': ['Playfair Display', 'Scheherazade New', 'serif']
                    },
                    boxShadow: {
                        'custom': '0 10px 40px -10px rgba(92, 31, 37, 0.2)',
                        'custom-dark': '0 10px 40px -10px rgba(212, 175, 55, 0.3)'
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .active-tab {
            position: relative;
            color: #5C1F25;
            font-weight: bold;
        }

        .active-tab::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #5C1F25 0%, #D4AF37 100%);
            border-radius: 3px;
        }

        .dark .active-tab {
            color: #D4AF37;
        }

        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid rgba(92, 31, 37, 0.1);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(92, 31, 37, 0.25);
            border-color: rgba(92, 31, 37, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #5C1F25 0%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-accepted {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-delivered {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-cancelled {
            background-color: #f3f4f6;
            color: #374151;
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

        .order-card {
            transition: all 0.3s ease;
            border-left: 4px solid #5C1F25;
        }

        .dark .order-card {
            border-left-color: #D4AF37;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-arabic transition-colors duration-300" x-cloak>
    <!-- شريط التنقل العلوي -->
    <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- الشعار واسم الموقع -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23D4AF37' d='M50 10L15 50l35 40 35-40z'/%3E%3Ccircle fill='%235C1F25' cx='50' cy='50' r='20'/%3E%3Cpath fill='%23D4AF37' d='M50 40l5 15h10l-8 6 3 15-10-8-10 8 3-15-8-6h10z'/%3E%3C/svg%3E" alt="شعار مسجد الخانقية" class="h-10 w-10">
                        <span class="mr-3 text-xl font-bold text-primary-600 dark:text-golden-400 font-quranic">مسجد الخانقية</span>
                    </a>
                </div>

                <!-- أقسام الموقع -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('products') }}" :class="currentSection === 'products' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition">
                        المنتجات
                    </a>
                    <a href="{{ route('my-orders') }}" :class="currentSection === 'my-orders' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition">
                        طلباتي
                    </a>
                    <a href="{{ route('wallet') }}" :class="currentSection === 'wallet' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition" x-show="userType === 'student'">
                        المحفظة
                    </a>
                    <a href="{{ route('quran-cycle') }}" :class="currentSection === 'quran' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition">
                        الحلقة القرآنية
                    </a>
                    <a href="{{ route('offers') }}" :class="currentSection === 'offers' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition">
                        العروض
                    </a>
                    <a href="{{ route('settings') }}" :class="currentSection === 'settings' ? 'active-tab' : 'text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400'" class="px-3 py-2 font-medium transition">
                        الإعدادات
                    </a>
                </div>

                <!-- الجزء الأيمن (إشعارات، بروفايل) -->
                <div class="flex items-center">
                    <!-- زر وضع الظلام -->
                    <button @click="toggleDarkMode()" class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400 transition">
                        <i class="fas text-lg" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
                    </button>

                    <!-- الإشعارات -->
                    <div class="relative ml-3" @click="notificationsOpen = !notificationsOpen">
                        <button class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400 transition">
                            <i class="fas fa-bell"></i>
                            <span x-show="unreadNotifications > 0" class="absolute top-0 right-0 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center" x-text="unreadNotifications"></span>
                        </button>

                        <!-- قائمة الإشعارات -->
                        <div x-show="notificationsOpen" @click.outside="notificationsOpen = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
                            <div class="p-3 border-b dark:border-gray-700 bg-primary-500 text-white">
                                <h3 class="font-semibold">الإشعارات</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <a href="#" class="block px-4 py-3 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <div class="flex items-start">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.title"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="notification.time"></p>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                            <a href="#" class="block text-center px-4 py-2 text-sm text-primary-600 dark:text-golden-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                عرض جميع الإشعارات
                            </a>
                        </div>
                    </div>

                    <!-- البروفايل -->
                    <div class="relative ml-3">
                        <button class="flex items-center text-sm rounded-full focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='40' r='30' fill='%235C1F25'/%3E%3Ccircle cx='50' cy='100' r='40' fill='%23D4AF37'/%3E%3C/svg%3E" alt="صورة المستخدم">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- عنوان الصفحة -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-primary-600 dark:text-golden-400 font-quranic mb-2">🛒 طلباتي</h1>
            <p class="text-gray-600 dark:text-gray-400">إدارة ومتابعة جميع طلباتك في مكان واحد</p>
        </div>

        <!-- بطاقات إحصائية -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">إجمالي الطلبات</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white" x-text="totalOrders"></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md border-l-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">طلبات قيد الانتظار</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white" x-text="pendingOrders"></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">طلبات مكتملة</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white" x-text="completedOrders"></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md border-l-4 border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">إجمالي النقاط</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white" x-text="totalPoints"></h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                        <i class="fas fa-coins text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- فلترة الطلبات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
            <div class="flex flex-wrap gap-3">
                <button @click="filterOrders('all')" :class="currentFilter === 'all' ? 'bg-primary-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg transition">
                    جميع الطلبات
                </button>
                <button @click="filterOrders('pending')" :class="currentFilter === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg transition">
                    قيد الانتظار
                </button>
                <button @click="filterOrders('accepted')" :class="currentFilter === 'accepted' ? 'bg-green-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg transition">
                    مقبولة
                </button>
                <button @click="filterOrders('delivered')" :class="currentFilter === 'delivered' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg transition">
                    مسلمة
                </button>
                <button @click="filterOrders('cancelled')" :class="currentFilter === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-4 py-2 rounded-lg transition">
                    ملغاة
                </button>
            </div>
        </div>

        <!-- محتوى الطلبات -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- حالة التحميل -->
            <div x-show="loading" class="text-center py-12">
                <div class="loading-spinner mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">جاري تحميل الطلبات...</p>
            </div>

            <!-- رسالة عدم وجود طلبات -->
            <div x-show="!loading && filteredOrders.length === 0" class="text-center py-12">
                <i class="fas fa-shopping-cart text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-xl text-gray-600 dark:text-gray-400 mb-2">لا توجد طلبات</h3>
                <p class="text-gray-500 dark:text-gray-500">لم يتم العثور على أي طلبات تطابق معايير البحث.</p>
                <a href="{{ route('products') }}" class="inline-block mt-4 bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-shopping-bag ml-2"></i>
                    تصفح المنتجات
                </a>
            </div>

            <!-- قائمة الطلبات -->
            <div x-show="!loading && filteredOrders.length > 0" class="divide-y divide-gray-200 dark:divide-gray-700">
                <template x-for="order in filteredOrders" :key="order.id">
                    <div class="order-card bg-white dark:bg-gray-800 p-6 hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                            <div class="flex-1">
                                <!-- رأس الطلب -->
                                <div class="flex flex-wrap items-center gap-4 mb-4">
                                    <h3 class="text-lg font-bold text-primary-700 dark:text-golden-300">الطلب #<span x-text="order.id"></span></h3>
                                    <span class="status-badge" :class="getStatusClass(order.status)" x-text="getStatusText(order.status)"></span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400" x-text="formatDate(order.created_at)"></span>
                                </div>

                                <!-- معلومات الطلب -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                                            <span class="font-medium">السعر الكلي:</span>
                                            <span class="text-primary-600 dark:text-golden-400 font-bold" x-text="order.total_price + ' نقطة'"></span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">السعر النهائي:</span>
                                            <span class="text-green-600 dark:text-green-400 font-bold" x-text="order.final_price + ' نقطة'"></span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                                            <span class="font-medium">الخصم:</span>
                                            <span x-text="order.discount || 'لا يوجد'"></span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">عدد المنتجات:</span>
                                            <span x-text="order.products.length"></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- المنتجات -->
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 dark:text-gray-300 mb-2">المنتجات:</p>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <template x-for="product in order.products" :key="product.id">
                                                <div class="flex justify-between items-center py-1">
                                                    <div>
                                                        <span class="font-medium text-gray-800 dark:text-gray-200" x-text="product.name"></span>
                                                        <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">× <span x-text="product.quantity"></span></span>
                                                    </div>
                                                    <span class="text-primary-600 dark:text-golden-400 font-medium" x-text="product.subtotal + ' نقطة'"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- الإجراءات -->
                            <div class="flex flex-col gap-2 lg:w-48">
                                <template x-if="['pending', 'accepted'].includes(order.status)">
                                    <button @click="cancelOrder(order.id)" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transition">
                                        <i class="fas fa-times ml-2"></i>
                                        إلغاء الطلب
                                    </button>
                                </template>
                                <button @click="viewOrderDetails(order.id)" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition">
                                    <i class="fas fa-eye ml-2"></i>
                                    تفاصيل الطلب
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </main>

    <script>
        function ordersApp() {
            return {
                // بيانات التطبيق
                currentSection: 'my-orders',
                isDark: localStorage.getItem('darkMode') === 'true',
                userType: 'student',
                notificationsOpen: false,
                unreadNotifications: 3,
                notifications: [
                    { id: 1, title: 'طلب جديد', message: 'تم استلام طلبك رقم #1234', time: 'منذ 5 دقائق' },
                    { id: 2, title: 'عرض خاص', message: 'خصم 20% على جميع الكتب هذا الأسبوع', time: 'منذ ساعة' },
                    { id: 3, title: 'تذكير الحلقة', message: 'حلقة القرآن غداً الساعة 4 عصراً', time: 'منذ يوم' }
                ],

                // بيانات الطلبات
                loading: true,
                allOrders: [],
                filteredOrders: [],
                currentFilter: 'all',
                totalOrders: 0,
                pendingOrders: 0,
                completedOrders: 0,
                totalPoints: 0,

                // رابط API
                API_URL: "http://127.0.0.1:8000/api/order",

                init() {
                    this.toggleDarkMode(this.isDark);
                    this.loadOrders();
                },

                toggleDarkMode(value = null) {
                    if (value === null) {
                        this.isDark = !this.isDark;
                    } else {
                        this.isDark = value;
                    }

                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                    }
                },

                // تحميل الطلبات
                async loadOrders() {
                    this.loading = true;

                    try {
                        const token = localStorage.getItem("auth_token");

                        if (!token) {
                            this.showNotification("يجب تسجيل الدخول أولاً", "error");
                            return;
                        }

                        const response = await fetch(`${this.API_URL}/myOrders`, {
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Accept": "application/json"
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        if (data.success) {
                            this.allOrders = data.orders;
                            this.filteredOrders = [...this.allOrders];
                            this.updateStatistics();
                            this.showNotification("تم تحميل الطلبات بنجاح", "success");
                        } else {
                            this.showNotification("فشل في جلب الطلبات: " + (data.message ?? "خطأ غير معروف"), "error");
                        }
                    } catch (error) {
                        console.error("Error loading orders:", error);
                        this.showNotification("حدث خطأ أثناء تحميل الطلبات", "error");
                    } finally {
                        this.loading = false;
                    }
                },

                // تحديث الإحصائيات
                updateStatistics() {
                    this.totalOrders = this.allOrders.length;
                    this.pendingOrders = this.allOrders.filter(order => order.status === 'pending').length;
                    this.completedOrders = this.allOrders.filter(order => order.status === 'delivered').length;
                    this.totalPoints = this.allOrders
                        .filter(order => order.status === 'delivered')
                        .reduce((sum, order) => sum + parseFloat(order.final_price || 0), 0);
                },

                // تصفية الطلبات
                filterOrders(status) {
                    this.currentFilter = status;

                    if (status === 'all') {
                        this.filteredOrders = [...this.allOrders];
                    } else {
                        this.filteredOrders = this.allOrders.filter(order => order.status === status);
                    }
                },

                // إلغاء الطلب
                async cancelOrder(orderId) {
                    if (!confirm("هل أنت متأكد من إلغاء هذا الطلب؟")) return;

                    try {
                        const token = localStorage.getItem("auth_token");
                        const response = await fetch(`${this.API_URL}/cancel?order_id=${orderId}`, {
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Accept": "application/json"
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();
                        this.showNotification(data.message, "success");
                        this.loadOrders(); // إعادة تحميل الطلبات لتحديث الحالة
                    } catch (error) {
                        console.error("Error cancelling order:", error);
                        this.showNotification("فشل إلغاء الطلب", "error");
                    }
                },

                // عرض تفاصيل الطلب
                viewOrderDetails(orderId) {
                    alert(`عرض تفاصيل الطلب #${orderId} - هذه الميزة قيد التطوير`);
                },

                // الحصول على كلاس الحالة
                getStatusClass(status) {
                    switch(status) {
                        case 'pending': return 'status-pending';
                        case 'accepted': return 'status-accepted';
                        case 'rejected': return 'status-rejected';
                        case 'delivered': return 'status-delivered';
                        case 'cancelled': return 'status-cancelled';
                        default: return 'status-pending';
                    }
                },

                // الحصول على نص الحالة
                getStatusText(status) {
                    switch(status) {
                        case 'pending': return 'قيد الانتظار';
                        case 'accepted': return 'مقبول';
                        case 'rejected': return 'مرفوض';
                        case 'delivered': return 'تم التسليم';
                        case 'cancelled': return 'ملغى';
                        default: return 'قيد الانتظار';
                    }
                },

                // تنسيق التاريخ
                formatDate(dateString) {
                    if (!dateString) return 'غير محدد';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('ar-SA');
                },

                // عرض الإشعارات
                showNotification(message, type = 'success') {
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
            }
        }
    </script>
</body>
</html>
