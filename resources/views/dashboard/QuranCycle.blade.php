<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الحلقات القرآنية</title>
    <!-- خطوط Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        success: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        warning: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
        }

        .card {
            @apply bg-white dark:bg-gray-800 rounded-2xl shadow-soft p-6;
        }

        .btn-primary {
            @apply bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50;
        }

        .btn-secondary {
            @apply bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50;
        }

        .badge {
            @apply px-2 py-1 text-xs rounded-full font-medium;
        }

        .badge-success {
            @apply badge bg-success-100 dark:bg-success-900/40 text-success-700 dark:text-success-300;
        }

        .badge-warning {
            @apply badge bg-warning-100 dark:bg-warning-900/40 text-warning-700 dark:text-warning-300;
        }

        .badge-info {
            @apply badge bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-300;
        }

        /* تأثيرات للبطاقات */
        .stat-card, .circle-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover, .circle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15);
        }

        /* تخصيص شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-700 rounded-full;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded-full;
        }

        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400 dark:bg-gray-500;
        }

        /* تأثيرات للصور */
        .teacher-img {
            transition: transform 0.3s ease;
        }

        .circle-card:hover .teacher-img {
            transform: scale(1.05);
        }

        /* أنيميشن للعدادات */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .count-animation {
            animation: countUp 1s ease-out;
        }

        /* تخصيص عناصر الإدخال */
        select {
            @apply bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 p-6 transition-colors duration-200">
    <div class="max-w-7xl mx-auto">
        <!-- العنوان الرئيسي -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">نظام إدارة الحلقات القرآنية</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">إحصاءات عامة وإدارة الحلقات التعليمية</p>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl shadow-soft p-6 border-l-4 border-primary-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-100 dark:bg-primary-900/30 p-3 rounded-xl">
                        <i class="fas fa-book-open text-primary-600 dark:text-primary-400 text-xl"></i>
                    </div>
                    <div class="mr-4 flex-1">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white count-animation">12</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">عدد الحلقات</p>
                    </div>
                    <div class="text-xs text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up ml-1"></i> 2 جديد
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl shadow-soft p-6 border-l-4 border-success-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-success-100 dark:bg-success-900/30 p-3 rounded-xl">
                        <i class="fas fa-users text-success-600 dark:text-success-400 text-xl"></i>
                    </div>
                    <div class="mr-4 flex-1">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white count-animation">142</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">إجمالي الطلاب</p>
                    </div>
                    <div class="text-xs text-success-600 dark:text-success-400 bg-success-50 dark:bg-success-900/20 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up ml-1"></i> 14 جديد
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl shadow-soft p-6 border-l-4 border-warning-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-warning-100 dark:bg-warning-900/30 p-3 rounded-xl">
                        <i class="fas fa-chalkboard-teacher text-warning-600 dark:text-warning-400 text-xl"></i>
                    </div>
                    <div class="mr-4 flex-1">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white count-animation">8</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">عدد المعلمين</p>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl shadow-soft p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/30 p-3 rounded-xl">
                        <i class="fas fa-tasks text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                    <div class="mr-4 flex-1">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white count-animation">86%</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">معدل الحضور</p>
                    </div>
                    <div class="text-xs text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up ml-1"></i> 5%
                    </div>
                </div>
            </div>
        </div>

        <!-- قائمة الحلقات -->
        <div class="card">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">الحلقات القرآنية</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إدارة الحلقات وتفاصيلها</p>
                </div>

                <div class="flex flex-col sm:flex-row mt-4 md:mt-0 space-y-3 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse">
                    <div class="relative flex-1">
                        <select class="w-full pr-10 pl-3 py-2">
                            <option>جميع الحلقات</option>
                            <option>الحلقات النشطة</option>
                            <option>الحلقات المكتملة</option>
                            <option>الحلقات المتوقفة</option>
                        </select>
                        <i class="fas fa-filter absolute right-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="relative flex-1">
                        <input type="text" placeholder="بحث في الحلقات..." class="w-full pr-10 pl-3 py-2">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>

                    <button class="btn-primary py-2">
                        <i class="fas fa-plus ml-2"></i>
                        حلقة جديدة
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- حلقة 1 -->
                <div class="circle-card bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-primary-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-bold text-gray-800 dark:text-white">الحلقة الأولى</h4>
                        <span class="badge-success">نشطة</span>
                    </div>

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden border-2 border-white shadow-sm">
                            <img class="teacher-img h-12 w-12 object-cover" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="المعلم">
                        </div>
                        <div class="mr-3">
                            <div class="text-sm font-medium text-gray-800 dark:text-white">عمر أحمد</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">معلم قرآن كريم</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">الطلاب</div>
                            <div class="font-bold text-gray-800 dark:text-white">15</div>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">المستوى</div>
                            <div class="font-bold text-gray-800 dark:text-white">مبتدئ</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>تقدم الحلقة</span>
                            <span>65%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary-500 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <button class="btn-secondary flex-1 py-2 text-sm">
                            <i class="fas fa-eye ml-1"></i>
                            عرض
                        </button>
                        <button class="btn-primary flex-1 py-2 text-sm">
                            <i class="fas fa-edit ml-1"></i>
                            تعديل
                        </button>
                    </div>
                </div>

                <!-- حلقة 2 -->
                <div class="circle-card bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-success-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-bold text-gray-800 dark:text-white">الحلقة الثانية</h4>
                        <span class="badge-success">نشطة</span>
                    </div>

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden border-2 border-white shadow-sm">
                            <img class="teacher-img h-12 w-12 object-cover" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=688&q=80" alt="المعلمة">
                        </div>
                        <div class="mr-3">
                            <div class="text-sm font-medium text-gray-800 dark:text-white">سارة محمد</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">معلمة قرآن كريم</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">الطلاب</div>
                            <div class="font-bold text-gray-800 dark:text-white">12</div>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">المستوى</div>
                            <div class="font-bold text-gray-800 dark:text-white">متوسط</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>تقدم الحلقة</span>
                            <span>82%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-success-500 h-2 rounded-full" style="width: 82%"></div>
                        </div>
                    </div>

                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <button class="btn-secondary flex-1 py-2 text-sm">
                            <i class="fas fa-eye ml-1"></i>
                            عرض
                        </button>
                        <button class="btn-primary flex-1 py-2 text-sm">
                            <i class="fas fa-edit ml-1"></i>
                            تعديل
                        </button>
                    </div>
                </div>

                <!-- حلقة 3 -->
                <div class="circle-card bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-warning-500"></div>
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-bold text-gray-800 dark:text-white">الحلقة المتقدمة</h4>
                        <span class="badge-warning">شبه مكتملة</span>
                    </div>

                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden border-2 border-white shadow-sm">
                            <img class="teacher-img h-12 w-12 object-cover" src="https://images.unsplash.com/photo-1552058544-f2b08422138a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=699&q=80" alt="المعلم">
                        </div>
                        <div class="mr-3">
                            <div class="text-sm font-medium text-gray-800 dark:text-white">خالد علي</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">معلم قرآن كريم</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">الطلاب</div>
                            <div class="font-bold text-gray-800 dark:text-white">8</div>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700/50 rounded-lg p-3 text-center">
                            <div class="text-sm text-gray-500 dark:text-gray-400">المستوى</div>
                            <div class="font-bold text-gray-800 dark:text-white">متقدم</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>تقدم الحلقة</span>
                            <span>92%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-warning-500 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>

                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <button class="btn-secondary flex-1 py-2 text-sm">
                            <i class="fas fa-eye ml-1"></i>
                            عرض
                        </button>
                        <button class="btn-primary flex-1 py-2 text-sm">
                            <i class="fas fa-edit ml-1"></i>
                            تعديل
                        </button>
                    </div>
                </div>
            </div>

            <!-- تذييل القائمة -->
            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 sm:mb-0">
                    عرض 1-3 من 12 حلقة
                </p>
                <div class="flex space-x-2 rtl:space-x-reverse">
                    <button class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="px-3 py-1 rounded-lg bg-primary-500 text-white">1</button>
                    <button class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">2</button>
                    <button class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">3</button>
                    <button class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">4</button>
                    <button class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- زر تبديل الوضع الليلي -->
    <button id="themeToggle" class="fixed bottom-6 left-6 bg-white dark:bg-gray-800 rounded-full p-3 shadow-lg border border-gray-200 dark:border-gray-700">
        <i class="fas fa-moon text-gray-700 dark:text-yellow-400"></i>
    </button>

    <script>
        // تبديل الوضع الليلي
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // التحقق من الإعدادات المحفوظة
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
        });

        // تأثيرات العدادات
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.count-animation');
            counters.forEach(counter => {
                counter.style.opacity = '0';
                setTimeout(() => {
                    counter.style.opacity = '1';
                }, 200);
            });
        });
    </script>
</body>
</html>
