<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="dashboard()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة التحكم' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        'arabic': ['Tajawal', 'ui-sans-serif', 'system-ui']
                    },
                    transitionProperty: {
                        'width': 'width',
                        'height': 'height',
                        'spacing': 'margin, padding',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts - Tajawal (Arabic) -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s ease-in-out; }
        .page-transition { transition: opacity 0.3s ease-in-out; }

        /* تخصيصات تيلويند */
        @layer components {
            body {
                font-family: 'Tajawal', sans-serif;
            }
            .btn-primary {
                @apply bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center;
            }
            .btn-secondary {
                @apply bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center;
            }
            .card {
                @apply bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700;
            }
            .table-header {
                @apply bg-gray-50 dark:bg-gray-700 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider;
            }
            .nav-item {
                @apply flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-gray-700 transition-colors duration-200 rounded-lg mx-2;
            }
            .nav-item-active {
                @apply bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-200 font-medium;
            }
        }

        /* تأثيرات مخصصة */
        .shadow-custom {
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .shadow-custom {
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.15);
        }

        /* شريط التمرير المخصص */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5a5a5;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-200" x-cloak>
    <!-- طبقة التعتيم للجوال -->
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden">
    </div>

    <div class="flex">
        <!-- الشريط الجانبي -->
        <div class="sidebar-transition fixed lg:relative w-64 h-screen bg-white dark:bg-gray-800 shadow-custom z-50 flex flex-col"
             :class="{ '-mr-64 lg:mr-0': !sidebarOpen, 'mr-0': sidebarOpen }">
            <div class="p-5 border-b dark:border-gray-700">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-chart-line ml-3 text-primary-600"></i>
                    <span class="bg-gradient-to-l from-primary-600 to-blue-400 bg-clip-text text-transparent">لوحة التحكم</span>
                </h1>
            </div>

            <nav class="mt-4 flex-1 overflow-y-auto py-2">
                <a href="{{ route('dashboard.home') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'dashboard' }">
                    <i class="fas fa-home ml-3 text-lg"></i>
                    <span>النظرة العامة</span>
                </a>

                <a href="{{ route('dashboard.users') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'users' }">
                    <i class="fas fa-users ml-3 text-lg"></i>
                    <span>المستخدمين</span>
                    <span class="mr-auto bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-200 text-xs px-2 py-1 rounded-full">+24</span>
                </a>

                <a href="{{ route('dashboard.products') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'products' }">
                    <i class="fas fa-box ml-3 text-lg"></i>
                    <span>المنتجات</span>
                </a>

                <a href="{{ route('dashboard.quranCycle') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'quran-cycle' }">
                    <i class="fas fa-book-quran ml-3 text-lg"></i>
                    <span>الحلقات القرآنية</span>
                    <span class="mr-auto bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-200 text-xs px-2 py-1 rounded-full">جديد</span>
                </a>

                <a href="{{ route('dashboard.admins') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'admins' }">
                    <i class="fas fa-user-shield ml-3 text-lg"></i>
                    <span>المشرفين</span>
                </a>

                <a href="{{ route('dashboard.offers') }}"
                   class="nav-item"
                   :class="{ 'nav-item-active': currentPage === 'offers' }">
                    <i class="fas fa-tags ml-3 text-lg"></i>
                    <span>العروض</span>
                </a>

                <!-- قسم إضافي للتقارير -->
                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase tracking-wider">التقارير</p>
                </div>

                <a href="#"
                   class="nav-item">
                    <i class="fas fa-chart-bar ml-3 text-lg"></i>
                    <span>تقارير المبيعات</span>
                </a>

                <a href="#"
                   class="nav-item">
                    <i class="fas fa-chart-pie ml-3 text-lg"></i>
                    <span>التقارير الإحصائية</span>
                </a>
            </nav>

            <!-- قسم الإعدادات -->
            <div class="w-full p-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <button @click="isDark = !isDark" class="nav-item w-full">
                    <i class="fas ml-3 text-lg" :class="{ 'fa-sun text-yellow-500': isDark, 'fa-moon text-indigo-500': !isDark }"></i>
                    <span x-text="isDark ? 'الوضع المضيء' : 'الوضع الداكن'"></span>
                </button>

                <a href="#" class="nav-item w-full">
                    <i class="fas fa-cog ml-3 text-lg"></i>
                    <span>الإعدادات</span>
                </a>

                <a href="#" class="nav-item w-full">
                    <i class="fas fa-question-circle ml-3 text-lg"></i>
                    <span>المساعدة والدعم</span>
                </a>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col min-h-screen" :class="{ 'lg:ml-64': sidebarOpen }">
            <!-- الرأس -->
            <header class="bg-white dark:bg-gray-800 shadow-sm p-4 flex justify-between items-center sticky top-0 z-30">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-300 lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- شريط البحث -->
                    <div class="hidden md:flex items-center mr-4 bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2">
                        <i class="fas fa-search text-gray-400 ml-2"></i>
                        <input type="text" placeholder="بحث..." class="bg-transparent border-none focus:ring-0 outline-none text-sm w-48">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <h2 class="text-lg font-semibold dark:text-white hidden sm:block" x-text="pageTitle"></h2>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- إشعارات -->
                    <button class="relative p-2 text-gray-500 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -left-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- الرسائل -->
                    <button class="relative p-2 text-gray-500 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-envelope text-xl"></i>
                        <span class="absolute -top-1 -left-1 bg-blue-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">5</span>
                    </button>

                    <!-- الملف الشخصي -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name=مدير+النظام&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full" alt="Profile">
                                <span class="absolute bottom-0 left-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 hidden md:block">مدير النظام</span>
                            <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             @click.away="open = false"
                             class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-1 z-50 border border-gray-100 dark:border-gray-700">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                <i class="fas fa-user ml-2 text-gray-400"></i>
                                <span>الملف الشخصي</span>
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                <i class="fas fa-cog ml-2 text-gray-400"></i>
                                <span>الإعدادات</span>
                            </a>
                            <div class="border-t dark:border-gray-700 my-1"></div>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                <i class="fas fa-sign-out-alt ml-2"></i>
                                <span>تسجيل الخروج</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- المحتوى الديناميكي -->
            <main class="flex-1 p-6 overflow-auto bg-gray-50 dark:bg-gray-900">
                <!-- عناصر تحكم الصفحة -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold dark:text-white" x-text="pageTitle"></h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">مرحباً بعودتك! إليك آخر التحديثات والإحصائيات.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button class="btn-primary">
                            <i class="fas fa-plus ml-2"></i>
                            إضافة جديد
                        </button>
                    </div>
                </div>

                <!-- محتوى الصفحة -->
                <div class="page-transition">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- الخصائص والدوال الخاصة بـ Alpine.js -->
    <script>
        function dashboard() {
            return {
                currentPage: 'dashboard',
                pageTitle: 'لوحة التحكم',
                sidebarOpen: window.innerWidth >= 1024,
                isDark: localStorage.getItem('darkMode') === 'true',

                init() {
                    // تحديد الصفحة الحالية بناءً على URL
                    this.detectCurrentPage();

                    // استعادة وضع التصميم من localStorage
                    this.isDark = localStorage.getItem('darkMode') === 'true';
                    this.applyDarkMode();

                    // الاستماع لتغير حجم النافذة لتعديل حالة الشريط الجانبي
                    window.addEventListener('resize', () => {
                        this.sidebarOpen = window.innerWidth >= 1024;
                    });
                },

                detectCurrentPage() {
                    const path = window.location.pathname;
                    if (path.includes('users')) this.currentPage = 'users';
                    else if (path.includes('products')) this.currentPage = 'products';
                    else if (path.includes('quran-cycle')) this.currentPage = 'quran-cycle';
                    else if (path.includes('admins')) this.currentPage = 'admins';
                    else if (path.includes('offers')) this.currentPage = 'offers';
                    else this.currentPage = 'dashboard';

                    // تحديث عنوان الصفحة
                    this.updatePageTitle();
                },

                updatePageTitle() {
                    switch(this.currentPage) {
                        case 'users': this.pageTitle = 'إدارة المستخدمين'; break;
                        case 'products': this.pageTitle = 'إدارة المنتجات'; break;
                        case 'quran-cycle': this.pageTitle = 'الحلقات القرآنية'; break;
                        case 'admins': this.pageTitle = 'إدارة المشرفين'; break;
                        case 'offers': this.pageTitle = 'إدارة العروض'; break;
                        default: this.pageTitle = 'لوحة التحكم';
                    }

                    // تحديث عنوان الصفحة في المتصفح
                    document.title = this.pageTitle + ' | لوحة التحكم';
                },

                applyDarkMode() {
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
