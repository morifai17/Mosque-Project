<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="mainApp()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقاط الطالب | مسجد الخانقية</title>

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

        .star-badge {
            position: absolute;
            top: -10px;
            left: -10px;
            background: linear-gradient(135deg, #D4AF37 0%, #F9A825 100%);
            color: #5C1F25;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
        }

        .dark .star-badge {
            border: 2px solid #1F2937;
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #5C1F25;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .dark .product-badge {
            background: #D4AF37;
            color: #1F2937;
        }

        /* تنسيقات خاصة بصفحة النقاط */
        .points-card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 15px 50px rgba(92, 31, 37, 0.15);
            text-align: center;
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
        }

        .points-title {
            color: #5C1F25;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .points-number {
            font-size: 80px;
            font-weight: bold;
            color: #D4AF37;
            margin: 30px 0;
            text-shadow: 2px 2px 10px rgba(212, 175, 55, 0.3);
        }

        .points-label {
            color: #5C1F25;
            font-size: 20px;
            margin-bottom: 40px;
        }

        .mosque-name {
            color: #5C1F25;
            font-size: 18px;
            margin-top: 30px;
            opacity: 0.8;
        }

        .dark .points-card {
            background: #374151;
            box-shadow: 0 15px 50px rgba(212, 175, 55, 0.15);
        }

        .dark .points-title,
        .dark .points-label,
        .dark .mosque-name {
            color: #D4AF37;
        }

        @media (max-width: 768px) {
            .points-number {
                font-size: 60px;
            }

            .points-card {
                padding: 30px;
                margin: 30px auto;
            }
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

    <!-- محتوى النقاط -->
    <div class="points-container">
        <div class="points-card">
            <h1 class="points-title">نقاط الطالب</h1>
            <div class="points-number">345</div>
            <p class="points-label">نقطة</p>
            <p class="mosque-name">مسجد الخانقية</p>
        </div>
    </div>

    <!-- سيتم تحميل المكونات من ملفات خارجية -->
    <script>
        // بيانات التطبيق الرئيسية
        function mainApp() {
            return {
                currentSection: 'points',
                isDark: localStorage.getItem('darkMode') === 'true',
                userType: 'student', // أو 'teacher'
                notificationsOpen: false,
                profileOpen: false,
                unreadNotifications: 3,
                notifications: [
                    { id: 1, title: 'طلب جديد', message: 'تم استلام طلبك رقم #1234', time: 'منذ 5 دقائق' },
                    { id: 2, title: 'عرض خاص', message: 'خصم 20% على جميع الكتب هذا الأسبوع', time: 'منذ ساعة' },
                    { id: 3, title: 'تذكير الحلقة', message: 'حلقة القرآن غداً الساعة 4 عصراً', time: 'منذ يوم' }
                ],

                init() {
                    // تطبيق وضع التصميم عند التحميل
                    this.toggleDarkMode(this.isDark);
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
                }
            }
        }
    </script>
</body>
</html>
