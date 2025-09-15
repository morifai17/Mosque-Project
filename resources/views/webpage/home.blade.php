<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="mainApp()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية | مسجد الخانقية</title>

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
        <!-- قسم الطلاب المتفوقين -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-primary-600 dark:text-golden-400 font-quranic">الطلاب المتفوقين</h2>
                <a href="{{ route('quran-cycle') }}" class="text-primary-500 dark:text-golden-300 hover:underline flex items-center">
                    <span>عرض الكل</span>
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="(student, index) in topStudents" :key="student.id">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden card-hover relative">
                        <div class="star-badge" x-text="index+1"></div>
                        <img :src="student.image" :alt="student.name" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-primary-700 dark:text-golden-300" x-text="student.name"></h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1" x-text="student.level"></p>
                            <div class="mt-3 flex items-center">
                                <span class="text-golden-500 dark:text-golden-300">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star" :class="{'opacity-30': student.rating < 2}"></i>
                                    <i class="fas fa-star" :class="{'opacity-30': student.rating < 3}"></i>
                                    <i class="fas fa-star" :class="{'opacity-30': student.rating < 4}"></i>
                                    <i class="fas fa-star" :class="{'opacity-30': student.rating < 5}"></i>
                                </span>
                                <span class="mr-2 text-sm text-gray-500 dark:text-gray-400" x-text="student.rating"></span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" x-text="student.achievement"></p>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- قسم المنتجات الأكثر طلباً -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-primary-600 dark:text-golden-400 font-quranic">المنتجات الأكثر طلباً</h2>
                <a href="{{ route('products') }}" class="text-primary-500 dark:text-golden-300 hover:underline flex items-center">
                    <span>عرض الكل</span>
                    <i class="fas fa-arrow-left mr-2 text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="product in popularProducts" :key="product.id">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden card-hover relative">
                        <span class="product-badge" x-text="product.badge" x-show="product.badge"></span>
                        <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-primary-700 dark:text-golden-300" x-text="product.name"></h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm" x-text="product.description"></p>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-primary-600 dark:text-golden-400 font-bold" x-text="product.price"></span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-shopping-cart ml-1"></i>
                                    <span x-text="product.orders"></span>
                                </span>
                            </div>
                            <button class="mt-4 w-full bg-primary-500 hover:bg-primary-600 dark:bg-golden-500 dark:hover:bg-golden-600 text-white py-2 rounded-lg transition">
                                <i class="fas fa-cart-plus ml-2"></i>
                                أضف إلى السلة
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- سيتم تحميل المحتوى الديناميكي هنا -->
        @yield('content')
    </main>

    <!-- سيتم تحميل المكونات من ملفات خارجية -->
    <script>
        // بيانات التطبيق الرئيسية
        function mainApp() {
            return {
                currentSection: '{{ Route::currentRouteName() }}',
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
                topStudents: [
                    {
                        id: 1,
                        name: 'أحمد محمد',
                        level: 'المستوى الثالث',
                        rating: 4.8,
                        achievement: 'أتم حفظ 5 أجزاء هذا الشهر',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Ccircle cx=\'100\' cy=\'70\' r=\'60\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'200\' r=\'80\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 2,
                        name: 'فاطمة عبد الله',
                        level: 'المستوى الرابع',
                        rating: 4.9,
                        achievement: 'أفضل أداء في التلاوة هذا الأسبوع',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Ccircle cx=\'100\' cy=\'70\' r=\'60\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'200\' r=\'80\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 3,
                        name: 'يوسف إبراهيم',
                        level: 'المستوى الثاني',
                        rating: 4.7,
                        achievement: 'أسرع طالب في إكمال الواجبات',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Ccircle cx=\'100\' cy=\'70\' r=\'60\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'200\' r=\'80\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 4,
                        name: 'سارة خالد',
                        level: 'المستوى الخامس',
                        rating: 4.9,
                        achievement: 'مثالية الحضور والانضباط',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Ccircle cx=\'100\' cy=\'70\' r=\'60\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'200\' r=\'80\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    }
                ],
                popularProducts: [
                    {
                        id: 1,
                        name: 'مصحف التجويد الملون',
                        description: 'مصحف برواية حفص مع تلوين أحكام التجويد',
                        price: '25 ر.س',
                        orders: 142,
                        badge: 'الأكثر مبيعاً',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect x=\'30\' y=\'40\' width=\'140\' height=\'120\' rx=\'5\' fill=\'%23D4AF37\'/%3E%3Crect x=\'40\' y=\'50\' width=\'120\' height=\'100\' rx=\'3\' fill=\'%23f8fafc\'/%3E%3Cpath d=\'M80 80 L120 80 L120 120 L80 120 Z\' fill=\'%235C1F25\'/%3E%3Cpath d=\'M85 85 L115 85 L115 115 L85 115 Z\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 2,
                        name: 'سجادة صلاة',
                        description: 'سجادة صلاة قابلة للطي ذات جودة عالية',
                        price: '45 ر.س',
                        orders: 98,
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect x=\'30\' y=\'40\' width=\'140\' height=\'120\' rx=\'5\' fill=\'%235C1F25\'/%3E%3Crect x=\'40\' y=\'50\' width=\'120\' height=\'100\' rx=\'3\' fill=\'%23D4AF37\'/%3E%3Cpath d=\'M70 70 L130 70 L130 130 L70 130 Z\' fill=\'%235C1F25\'/%3E%3Cpath d=\'M75 75 L125 75 L125 125 L75 125 Z\' fill=\'%23f8fafc\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 3,
                        name: 'سبحة من خشب الزيتون',
                        description: 'سبحة مصنوعة يدوياً من خشب الزيتون المميز',
                        price: '35 ر.س',
                        orders: 87,
                        badge: 'عرض خاص',
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Ccircle cx=\'100\' cy=\'100\' r=\'70\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'100\' r=\'60\' fill=\'%23D4AF37\'/%3E%3Ccircle cx=\'100\' cy=\'70\' r=\'10\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'130\' cy=\'90\' r=\'10\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'130\' cy=\'130\' r=\'10\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'100\' cy=\'150\' r=\'10\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'70\' cy=\'130\' r=\'10\' fill=\'%235C1F25\'/%3E%3Ccircle cx=\'70\' cy=\'90\' r=\'10\' fill=\'%235C1F25\'/%3E%3C/svg%3E'
                    },
                    {
                        id: 4,
                        name: 'كتاب تفسير السعدي',
                        description: 'تفسير القرآن الكريم للشيخ عبد الرحمن السعدي',
                        price: '75 ر.س',
                        orders: 76,
                        image: 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect x=\'40\' y=\'40\' width=\'120\' height=\'120\' rx=\'5\' fill=\'%235C1F25\'/%3E%3Crect x=\'50\' y=\'50\' width=\'100\' height=\'100\' rx=\'3\' fill=\'%23f8fafc\'/%3E%3Cpath d=\'M70 80 L130 80 L130 100 L70 100 Z\' fill=\'%235C1F25\'/%3E%3Cpath d=\'M70 110 L130 110 L130 120 L70 120 Z\' fill=\'%23D4AF37\'/%3E%3Cpath d=\'M70 125 L100 125 L100 130 L70 130 Z\' fill=\'%23D4AF37\'/%3E%3C/svg%3E'
                    }
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
