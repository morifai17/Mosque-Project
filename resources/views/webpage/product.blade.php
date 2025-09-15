<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="mainApp()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منتجات مسجد الخانقية</title>

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
                            500: '#5C1F25',
                            600: '#4A191F',
                            700: '#3E1419',
                            800: '#2F0F13',
                            900: '#1F0A0D'
                        },
                        golden: {
                            100: '#f9f0d9',
                            300: '#E6C875',
                            400: '#D4AF37',
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

        .loader {
            border-top-color: #D4AF37;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .islamic-pattern {
            background-color: #5C1F25;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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

    <main class="container mx-auto px-4 py-8">
        <div id="loading" class="flex flex-col items-center justify-center py-12">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <p class="text-gray-600 dark:text-gray-300">جاري تحميل المنتجات...</p>
        </div>

        <div id="error" class="hidden bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong class="font-bold">خطأ! </strong>
                <span id="errorMessage" class="block sm:inline mr-2"></span>
            </div>
            <div class="mt-2">
                <p class="text-sm">تأكد من:</p>
                <ul class="list-disc mr-4 text-sm">
                    <li>أن الخادم يعمل على <span id="serverUrl" class="font-mono">http://127.0.0.1:8000</span></li>
                    <li>أنك قمت بتصحيح دالة getProducts في Laravel</li>
                    <li>أن CORS مسموح به إذا كان الخادم على نطاق مختلف</li>
                </ul>
            </div>
        </div>

        <div id="productsContainer" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <!-- المنتجات سيتم إضافتها هنا -->
        </div>
    </main>

    <footer class="bg-primary-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 مسجد الخانقية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script>
        // عناصر DOM
        const loadingElement = document.getElementById('loading');
        const errorElement = document.getElementById('error');
        const errorMessageElement = document.getElementById('errorMessage');
        const productsContainer = document.getElementById('productsContainer');
        const serverUrlElement = document.getElementById('serverUrl');

        // حالة التطبيق
        const API_URL = 'http://127.0.0.1:8000/api/products/getProducts';

        // تهيئة التطبيق
        function init() {
            fetchData();
        }

        // جلب البيانات
        async function fetchData() {
            try {
                showLoading();
                hideError();

                const response = await fetch(API_URL);

                if (!response.ok) {
                    throw new Error(`خطأ في الشبكة: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && data.products) {
                    displayProducts(data.products);
                } else if (data.success && data.product) {
                    // دعم للتسمية القديمة
                    displayProducts(data.product);
                } else {
                    throw new Error('البيانات المستلمة غير متوقعة');
                }
            } catch (error) {
                showError(`فشل في جلب البيانات: ${error.message}`);
            }
        }

        // عرض المنتجات
        function displayProducts(products) {
            hideLoading();
            hideError();

            if (!products || products.length === 0) {
                showError('لا توجد منتجات لعرضها');
                return;
            }

            productsContainer.innerHTML = '';

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover';

                productCard.innerHTML = `
                    <div class="h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden relative">
                        ${product.image ?
                            `<img src="${product.image}" alt="${product.title || product.name}" class="w-full h-full object-cover">` :
                            `<div class="w-full h-full flex items-center justify-center text-primary-500 dark:text-golden-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>`
                        }
                        ${product.stock === 0 ?
                            '<span class="product-badge bg-red-500 text-white">نفذت الكمية</span>' :
                            (product.stock < 5 ? '<span class="product-badge bg-orange-500 text-white">كمية محدودة</span>' : '')
                        }
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">${product.title || product.name || 'منتج بدون عنوان'}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">${product.description || 'لا يوجد وصف للمنتج'}</p>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-primary-600 dark:text-golden-400">${product.price ? `${product.price} ر.س` : 'غير متوفر'}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">${product.stock || 0} متبقي في المخزن</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-100 text-xs px-3 py-1 rounded-full">
                                ${product.category ? (product.category.name || product.category.title) : 'بدون فئة'}
                            </span>
                            <button class="add-to-cart bg-golden-400 text-primary-800 px-4 py-2 rounded-lg font-semibold hover:bg-golden-500 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    data-id="${product.id}" ${product.stock === 0 ? 'disabled' : ''}>
                                <i class="fas fa-cart-plus ml-2"></i>إضافة إلى السلة
                            </button>
                        </div>
                    </div>
                `;

                productsContainer.appendChild(productCard);
            });

            // إضافة event listeners لأزرار السلة
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const product = products.find(p => p.id == productId);
                    if (product) {
                        alert(`تمت إضافة "${product.title || product.name}" إلى السلة`);
                    }
                });
            });

            productsContainer.classList.remove('hidden');
        }

        // دوال مساعدة لإدارة الواجهة
        function showLoading() {
            loadingElement.classList.remove('hidden');
            productsContainer.classList.add('hidden');
        }

        function hideLoading() {
            loadingElement.classList.add('hidden');
        }

        function showError(message) {
            errorMessageElement.textContent = message;
            errorElement.classList.remove('hidden');
            productsContainer.classList.add('hidden');
            hideLoading();
        }

        function hideError() {
            errorElement.classList.add('hidden');
        }

        // بيانات التطبيق الرئيسية
        function mainApp() {
            return {
                currentSection: 'products',
                isDark: localStorage.getItem('darkMode') === 'true',
                userType: 'student',
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
                    // تهيئة تحميل المنتجات
                    init();
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
