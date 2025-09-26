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

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .toast {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast.success {
            background-color: #10B981;
        }

        .toast.error {
            background-color: #EF4444;
        }

        .toast.warning {
            background-color: #F59E0B;
        }

        /* تنسيقات جديدة لعداد الكمية */
        .quantity-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px 0;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background-color: #e5e7eb;
        }

        .quantity-btn:first-child {
            border-radius: 6px 0 0 6px;
        }

        .quantity-btn:last-child {
            border-radius: 0 6px 6px 0;
        }

        .quantity-input {
            width: 50px;
            height: 35px;
            border: 1px solid #d1d5db;
            border-left: none;
            border-right: none;
            text-align: center;
            font-weight: bold;
        }

        .dark .quantity-btn {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        .dark .quantity-btn:hover {
            background-color: #4b5563;
        }

        .dark .quantity-input {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
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

                    <!-- زر السلة -->
                    <div class="relative ml-3" @click="cartOpen = !cartOpen">
                        <button class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-golden-400 transition">
                            <i class="fas fa-shopping-cart"></i>
                            <span x-show="cartItems.length > 0" class="absolute top-0 right-0 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center" x-text="cartItems.length"></span>
                        </button>

                        <!-- قائمة السلة -->
                        <div x-show="cartOpen" @click.outside="cartOpen = false" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden z-50">
                            <div class="p-3 border-b dark:border-gray-700 bg-primary-500 text-white">
                                <h3 class="font-semibold">سلة التسوق</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <template x-for="item in cartItems" :key="item.product_id">
                                    <div class="flex items-center px-4 py-3 border-b dark:border-gray-700">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="item.product_name"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                <span x-text="item.quantity"></span> × <span x-text="formatPrice(item.unit_price)"></span>
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm font-bold text-primary-600 dark:text-golden-400" x-text="formatPrice(item.total_item_price)"></span>
                                            <button @click="removeFromCart(item.product_id, 1)" class="text-red-500 hover:text-red-700 ml-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="cartItems.length === 0" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    السلة فارغة
                                </div>
                            </div>
                            <div class="p-3 border-t dark:border-gray-700">
                                <div class="flex justify-between mb-2">
                                    <span class="font-semibold">المجموع:</span>
                                    <span class="font-bold text-primary-600 dark:text-golden-400" x-text="formatPrice(cartTotal)"></span>
                                </div>
                                <button class="w-full bg-primary-600 hover:bg-primary-700 text-white py-2 rounded-lg font-semibold transition">
                                    اتمام الطلب
                                </button>
                            </div>
                        </div>
                    </div>

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

    <!-- منطقة الإشعارات -->
    <div id="toastContainer" class="toast-container"></div>

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
        const toastContainer = document.getElementById('toastContainer');

        // حالة التطبيق
        const API_URL = 'http://127.0.0.1:8000/api/products/getProducts';
        const CART_API_URL = 'http://127.0.0.1:8000/api/cart';

        // تهيئة التطبيق
        function init() {
            fetchData();
            fetchCart();
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

        // جلب محتويات السلة
        async function fetchCart() {
            const token = getAuthToken();
            if (!token) return;

            try {
                console.log('Fetching cart with token:', token.substring(0, 20) + '...');

                const response = await fetch(`${CART_API_URL}/get`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    credentials: 'include' // إذا كنت تستخدم sessions
                });

                console.log('Cart response status:', response.status);

                if (!response.ok) {
                    if (response.status === 401) {
                        showToast('جلسة العمل منتهية، يرجى تسجيل الدخول مرة أخرى', 'error');
                        localStorage.removeItem('auth_token');
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 2000);
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Cart data received:', data);

                if (data.success) {
                    updateCartUI(data.cart_items || data.items || [], data.cart_total || data.total || 0);
                } else {
                    console.warn('API returned success: false', data);
                    updateCartUI([], 0);
                }
            } catch (error) {
                console.error('خطأ في جلب السلة:', error);
                showToast('خطأ في تحميل سلة التسوق', 'error');
            }
        }

        // إضافة منتج إلى السلة
   async function addToCart(productId, productName, quantity = 1) {
    const token = getAuthToken();
    if (!token) return;

    try {
        console.log('Adding to cart:', { productId, productName, quantity, token: token.substring(0, 20) + '...' });

        const requestBody = {
            product_id: parseInt(productId),
            quantity: parseInt(quantity)
        };

        const response = await fetch(`${CART_API_URL}/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestBody)
        });

        if (!response.ok) {
            const errorData = await response.json();
            let errorMessage = errorData.message || 'فشل في إضافة المنتج إلى السلة';
            showToast(errorMessage, 'error');
            return;
        }

        const data = await response.json();
        if (data.success) {
            showToast(`تمت إضافة ${quantity} من "${productName}" إلى السلة`, 'success');
            fetchCart(); // تحديث السلة
        } else {
            showToast(data.message || 'فشل في إضافة المنتج إلى السلة', 'error');
        }
    } catch (error) {
        console.error('خطأ في إضافة المنتج إلى السلة:', error);
        showToast('خطأ في الاتصال بالخادم: ' + error.message, 'error');
    }
}




        // إزالة منتج من السلة
      async function removeFromCart(productId, quantity = null) {
    try {
        const requestBody = { product_id: productId };
        if (quantity !== null) {
            requestBody.quantity = quantity;
        }

        const response = await fetch(`${CART_API_URL}/remove`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${getAuthToken()}`
            },
            body: JSON.stringify(requestBody)
        });

        const data = await response.json();

        if (data.success) {
            showToast('تم تحديث السلة', 'success');
            fetchCart(); // تحديث السلة
        } else {
            showToast(data.message || 'فشل في تحديث السلة', 'error');
        }
    } catch (error) {
        showToast('خطأ في الاتصال بالخادم', 'error');
        console.error('خطأ في إزالة المنتج من السلة:', error);
    }
}
  function displayProducts(products) {
            hideLoading();
            hideError();

            if (!products || products.length === 0) {
                showError('لا توجد منتجات لعرضها');
                return;
            }

            console.log('المنتجات المستلمة:', products); // للتصحيح

            productsContainer.innerHTML = '';

            products.forEach(product => {
                // تصحيح خاصية المخزون
                const stock = product.stock !== undefined ? product.stock :
                             product.quantity !== undefined ? product.quantity :
                             product.available_quantity !== undefined ? product.available_quantity : 10; // قيمة افتراضية

                const maxQuantity = stock > 0 ? stock : 1;
                const initialQuantity = stock > 0 ? 1 : 0;

                console.log(`المنتج: ${product.title || product.name}, المخزون: ${stock}, الحد الأقصى: ${maxQuantity}`); // للتصحيح

                const productCard = document.createElement('div');
                productCard.className = 'bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md card-hover';
                productCard.dataset.productId = product.id;
                productCard.dataset.stock = stock; // تخزين المخزون كبيانات

                productCard.innerHTML = `
                    <div class="h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden relative">
                        ${product.image ?
                            `<img src="/storage/products/${product.image}"
     alt="${product.title || product.name}"
     class="w-full h-full object-cover">
` :
                            `<div class="w-full h-full flex items-center justify-center text-primary-500 dark:text-golden-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>`
                        }
                        ${stock === 0 ? '<span class="product-badge bg-red-500 text-white">نفذت الكمية</span>' :
                            (stock < 5 ? '<span class="product-badge bg-orange-500 text-white">كمية محدودة</span>' : '')
                        }
                    </div>

                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">${product.title || product.name || 'منتج بدون عنوان'}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">${product.description || 'لا يوجد وصف للمنتج'}</p>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-primary-600 dark:text-golden-400">${product.price ? `${product.price} ر.س` : 'غير متوفر'}</span>
                            <span class="text-sm ${stock <= 5 ? 'text-orange-500' : 'text-gray-500'} dark:${stock <= 5 ? 'text-orange-400' : 'text-gray-400'}">
                                ${stock} متبقي في المخزن
                            </span>
                        </div>

                        <!-- عداد الكمية المصحح -->
                        <div class="quantity-selector mb-4 ${stock === 0 ? 'opacity-50 pointer-events-none' : ''}">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" class="quantity-btn decrease w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center border border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <input type="number"
                                       min="1"
                                       max="${maxQuantity}"
                                       value="${initialQuantity}"
                                       class="quantity-input w-16 h-10 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-bold"
                                       ${stock === 0 ? 'disabled' : ''}
                                       data-max="${maxQuantity}">
                                <button type="button" class="quantity-btn increase w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center border border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-gray-500 dark:text-gray-400">الحد الأقصى: ${maxQuantity}</small>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-100 text-xs px-3 py-1 rounded-full">
                                ${product.category ? (product.category.name || product.category.title || 'بدون فئة') : 'بدون فئة'}
                            </span>
                            <button class="add-to-cart bg-golden-400 hover:bg-golden-500 text-primary-800 px-4 py-2 rounded-lg font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                                ${stock === 0 ? 'disabled' : ''}>
                                <i class="fas fa-cart-plus ml-2"></i>
                                ${stock === 0 ? 'نفذت الكمية' : 'إضافة إلى السلة'}
                            </button>
                        </div>
                    </div>
                `;

                productsContainer.appendChild(productCard);
            });

            // إضافة event listeners لأزرار السلة - الإصدار المحسن
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('[data-product-id]');
                    const productId = productCard.dataset.productId;
                    const productName = productCard.querySelector('h3').textContent;
                    const quantityInput = productCard.querySelector('.quantity-input');

                    // التحقق من أن القيمة رقمية وصحيحة
                    let quantity = parseInt(quantityInput.value);

                    if (isNaN(quantity) || quantity < 1) {
                        quantity = 1;
                        quantityInput.value = 1;
                    }

                    const maxQuantity = parseInt(quantityInput.getAttribute('data-max')) || parseInt(quantityInput.max) || 1;
                    if (quantity > maxQuantity) {
                        quantity = maxQuantity;
                        quantityInput.value = maxQuantity;
                        showToast(`تم ضبط الكمية إلى الحد الأقصى (${maxQuantity})`, 'warning');
                    }

                    console.log(`إضافة إلى السلة - المنتج: ${productId}, الكمية: ${quantity}, الحد الأقصى: ${maxQuantity}`);
                    addToCart(productId, productName, quantity);
                });
            });

            // أزرار زيادة الكمية - الإصدار المحسن
            document.querySelectorAll('.quantity-btn.increase').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('[data-product-id]');
                    const input = productCard.querySelector('.quantity-input');
                    const stock = parseInt(productCard.dataset.stock) || 1;

                    if (input.disabled) return;

                    let currentValue = parseInt(input.value) || 0;
                    const maxValue = parseInt(input.getAttribute('data-max')) || stock || 999;

                    console.log(`زيادة - القيمة الحالية: ${currentValue}, الحد الأقصى: ${maxValue}, المخزون: ${stock}`);

                    if (currentValue < maxValue) {
                        input.value = currentValue + 1;
                    } else {
                        showToast(`لا يمكن طلب أكثر من ${maxValue} وحدة`, 'warning');
                    }
                });
            });

            // أزرار تقليل الكمية - الإصدار المحسن
            document.querySelectorAll('.quantity-btn.decrease').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('[data-product-id]');
                    const input = productCard.querySelector('.quantity-input');

                    if (input.disabled) return;

                    let currentValue = parseInt(input.value) || 1;
                    const minValue = parseInt(input.min) || 1;

                    if (currentValue > minValue) {
                        input.value = currentValue - 1;
                    }
                });
            });

            // التحقق من صحة القيم المدخلة - الإصدار المحسن
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.disabled) return;

                    let value = parseInt(this.value) || 1;
                    const min = parseInt(this.getAttribute('min')) || 1;
                    const max = parseInt(this.getAttribute('data-max')) || parseInt(this.getAttribute('max')) || 999;

                    console.log(`تغيير القيمة - القيمة: ${value}, الحد الأدنى: ${min}, الحد الأقصى: ${max}`);

                    if (value < min) {
                        value = min;
                        showToast(`الحد الأدنى للطلب هو ${min} وحدة`, 'warning');
                    }

                    if (value > max) {
                        value = max;
                        showToast(`الحد الأقصى للطلب هو ${max} وحدة`, 'warning');
                    }

                    this.value = value;
                });

                input.addEventListener('input', function() {
                    // منع الإدخال غير الرقمي في الوقت الحقيقي
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value === '' || parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                });

                // منع الإدخال غير الرقمي
                input.addEventListener('keydown', function(e) {
                    // السماح فقط بالأرقام ومفاتيح التحكم
                    if (!/[\d]|Backspace|Delete|ArrowLeft|ArrowRight|Tab|Enter/.test(e.key)) {
                        e.preventDefault();
                    }
                });

                // التحقق عند اللصق
                input.addEventListener('paste', function(e) {
                    const pastedText = e.clipboardData.getData('text');
                    if (!/^\d+$/.test(pastedText)) {
                        e.preventDefault();
                        showToast('يُسمح فقط بإدخال الأرقام', 'warning');
                    }
                });
            });

            productsContainer.classList.remove('hidden');
        }

        // دالة fetchData محسنة لإظهار البيانات الخام
        async function fetchData() {
            try {
                showLoading();
                hideError();

                const response = await fetch(API_URL);
                console.log('استجابة الخادم:', response); // للتصحيح

                if (!response.ok) {
                    throw new Error(`خطأ في الشبكة: ${response.status}`);
                }

                const data = await response.json();
                console.log('البيانات المستلمة:', data); // للتصحيح

                if (data.success && data.products) {
                    displayProducts(data.products);
                } else if (data.success && data.product) {
                    // دعم للتسمية القديمة
                    displayProducts(data.product);
                } else if (Array.isArray(data)) {
                    // إذا كانت البيانات مصفوفة مباشرة
                    displayProducts(data);
                } else {
                    throw new Error('البيانات المستلمة غير متوقعة');
                }
            } catch (error) {
                console.error('تفاصيل الخطأ:', error); // للتصحيح
                showError(`فشل في جلب البيانات: ${error.message}`);
            }
        }





            // التحقق من صحة القيم المدخلة
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productCard = this.closest('[data-product-id]');
                    const min = parseInt(this.getAttribute('min')) || 1;
                    const max = parseInt(this.getAttribute('max')) || 999;
                    let value = parseInt(this.value) || min;

                    if (value < min) value = min;
                    if (value > max) value = max;

                    this.value = value;
                });
            });

            productsContainer.classList.remove('hidden');


        // تحديث واجهة السلة
        function updateCartUI(items, total) {
            try {
                // الطريقة الآمنة للوصول إلى Alpine store
                if (window.Alpine && Alpine.store('cart')) {
                    Alpine.store('cart').items = items || [];
                    Alpine.store('cart').total = total || 0;
                } else {
                    console.warn('Alpine store not available, using fallback');
                    // استخدم متغيرات بديلة
                    window.cartItems = items || [];
                    window.cartTotal = total || 0;
                }
            } catch (error) {
                console.error('Error updating cart UI:', error);
            }
        }

        // عرض رسالة toast
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);

    // إضافة إمكانية الإغلاق عند الضغط
    toast.addEventListener('click', () => {
        toast.classList.remove('show');
        setTimeout(() => toastContainer.removeChild(toast), 300);
    });

    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toastContainer.contains(toast)) toastContainer.removeChild(toast);
        }, 300);
    }, 3000);
}



        // الحصول على التوكن (يجب تعديل هذه الدالة بناءً على نظام المصادقة الخاص بك)
        function getAuthToken() {
            const token = localStorage.getItem('auth_token');

            if (!token) {
                console.error('No auth token found');
                showToast('يجب تسجيل الدخول أولاً', 'error');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
                return null;
            }

            // تحقق من صحة التوكن (يمكن إضافة المزيد من التحقق)
            if (token.length < 10) {
                console.error('Invalid token format');
                showToast('جلسة العمل غير صالحة', 'error');
                return null;
            }

            return token;
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

        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: [],
                total: 0,

                getItemCount() {
                    return this.items.length;
                },

                clearCart() {
                    this.items = [];
                    this.total = 0;
                }
            });
        });

        // بيانات التطبيق الرئيسية
        function mainApp() {
            return {
                currentSection: 'products',
                isDark: localStorage.getItem('darkMode') === 'true',
                userType: 'student',
                cartOpen: false,
                notificationsOpen: false,
                profileOpen: false,
                unreadNotifications: 3,

                // استخدام Alpine store أو fallback
                get cartItems() {
                    return Alpine.store('cart')?.items || window.cartItems || [];
                },

                get cartTotal() {
                    return Alpine.store('cart')?.total || window.cartTotal || 0;
                },

                notifications: [
                    { id: 1, title: 'طلب جديد', message: 'تم استلام طلبك رقم #1234', time: 'منذ 5 دقائق' },
                    { id: 2, title: 'عرض خاص', message: 'خصم 20% على جميع الكتب هذا الأسبوع', time: 'منذ ساعة' },
                    { id: 3, title: 'تذكير الحلقة', message: 'حلقة القرآن غداً الساعة 4 عصراً', time: 'منذ يوم' }
                ],

                init() {
                    // تهيئة المتغيرات البديلة
                    window.cartItems = window.cartItems || [];
                    window.cartTotal = window.cartTotal || 0;

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

                    localStorage.setItem('darkMode', this.isDark.toString());
                    document.documentElement.classList.toggle('dark', this.isDark);
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('ar-SA', {
                        style: 'currency',
                        currency: 'SAR'
                    }).format(price);
                },

                removeFromCart(productId, quantity = null) {
                    removeFromCart(productId, quantity);
                },

                // دالة مساعدة للتحقق من Alpine store
                checkAlpineStore() {
                    return !!(window.Alpine && Alpine.store('cart'));
                }
            }
        }

        // تهيئة المتغيرات البديلة globally
        window.cartItems = [];
        window.cartTotal = 0;
    </script>
</body>
</html>
