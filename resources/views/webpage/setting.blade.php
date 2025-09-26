<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="settingsApp()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات | مسجد الخانقية</title>

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

        .settings-card {
            box-shadow: 0 10px 40px -10px rgba(92, 31, 37, 0.2);
            border: 1px solid rgba(92, 31, 37, 0.1);
            transition: all 0.3s ease;
        }

        .dark .settings-card {
            box-shadow: 0 10px 40px -10px rgba(212, 175, 55, 0.3);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .toggle-bg {
            background: linear-gradient(135deg, #5C1F25 0%, #D4AF37 100%);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold gradient-text font-quranic">الإعدادات</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">إدارة إعدادات حسابك وتفضيلاتك</p>
        </div>

        <!-- بطاقة المعلومات الشخصية -->
        <div class="settings-card bg-white dark:bg-gray-800 rounded-xl p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-primary-700 dark:text-golden-300 font-quranic">المعلومات الشخصية</h3>
                <button
                    @click="editMode = !editMode"
                    :class="editMode ? 'bg-gray-500 hover:bg-gray-600' : 'bg-primary-500 hover:bg-primary-600 dark:bg-golden-500 dark:hover:bg-golden-600'"
                    class="text-white px-4 py-2 rounded-lg font-semibold transition flex items-center"
                >
                    <i class="fas" :class="editMode ? 'fa-times' : 'fa-edit'"></i>
                    <span class="mr-2" x-text="editMode ? 'إلغاء التعديل' : 'تعديل الملف الشخصي'"></span>
                </button>
            </div>

            <!-- عرض المعلومات (وضع القراءة) -->
            <div x-show="!editMode" class="fade-in">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm mb-1 text-gray-500 dark:text-gray-400">الاسم الأول</label>
                        <p class="text-lg text-gray-800 dark:text-white" x-text="userData.first_name"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-gray-500 dark:text-gray-400">الاسم الأخير</label>
                        <p class="text-lg text-gray-800 dark:text-white" x-text="userData.last_name"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-gray-500 dark:text-gray-400">رقم الهاتف</label>
                        <p class="text-lg text-gray-800 dark:text-white" x-text="userData.phone_number"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1 text-gray-500 dark:text-gray-400">العمر</label>
                        <p class="text-lg text-gray-800 dark:text-white" x-text="userData.age"></p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm mb-1 text-gray-500 dark:text-gray-400">الصورة الشخصية</label>
                        <div class="flex items-center space-x-4 mt-2">
                            <img class="h-16 w-16 rounded-full object-cover" :src="userData.avatar" alt="صورة المستخدم الحالية">
                        </div>
                    </div>
                </div>
            </div>

            <!-- تعديل المعلومات (وضع التحرير) -->
            <div x-show="editMode" x-transition:enter="fade-in" class="mt-4">
                <form id="profileForm" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">الاسم الأول</label>
                            <input
                                type="text"
                                name="first_name"
                                x-model="userData.first_name"
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            >
                        </div>
                        <div>
                            <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">الاسم الأخير</label>
                            <input
                                type="text"
                                name="last_name"
                                x-model="userData.last_name"
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            >
                        </div>
                        <div>
                            <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                            <input
                                type="text"
                                name="phone_number"
                                x-model="userData.phone_number"
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            >
                        </div>
                        <div>
                            <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">العمر</label>
                            <input
                                type="number"
                                name="age"
                                x-model="userData.age"
                                class="w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                            >
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">الصورة الشخصية</label>
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img class="h-16 w-16 rounded-full object-cover" :src="userData.avatar" alt="صورة المستخدم الحالية">
                                </div>
                                <div class="flex-1">
                                    <input
                                        type="file"
                                        name="avatar"
                                        id="avatarInput"
                                        @change="previewAvatar"
                                        class="w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-gray-700 dark:file:text-golden-300"
                                    >
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF بحد أقصى 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t dark:border-gray-700 flex justify-end mt-4 space-x-3">
                        <button
                            type="button"
                            @click="editMode = false"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center"
                        >
                            <i class="fas fa-times ml-2"></i>
                            إلغاء
                        </button>
                        <button
                            type="button"
                            @click="saveProfile"
                            class="bg-primary-500 hover:bg-primary-600 dark:bg-golden-500 dark:hover:bg-golden-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center"
                        >
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- بطاقة التفضيلات -->
        <div class="settings-card bg-white dark:bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-medium mb-4 text-primary-700 dark:text-golden-300 font-quranic">التفضيلات</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-2">
                    <div>
                        <span class="text-gray-700 dark:text-gray-300">وضع الظلام</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">تغيير مظهر التطبيق إلى الوضع الداكن</p>
                    </div>
                    <button type="button" @click="toggleDarkMode()" class="relative inline-flex h-7 w-14 items-center rounded-full toggle-bg transition">
                        <span class="inline-block h-5 w-5 transform bg-white rounded-full transition" :class="{ 'translate-x-8': isDark, 'translate-x-1': !isDark }"></span>
                    </button>
                </div>

                <div class="flex items-center justify-between py-2">
                    <div>
                        <span class="text-gray-700 dark:text-gray-300">إشعارات التطبيق</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">تلقي إشعارات مباشرة من التطبيق</p>
                    </div>
                    <button type="button" @click="appNotifications = !appNotifications" class="relative inline-flex h-7 w-14 items-center rounded-full" :class="appNotifications ? 'toggle-bg' : 'bg-gray-200 dark:bg-gray-700'">
                        <span class="inline-block h-5 w-5 transform bg-white rounded-full transition" :class="{ 'translate-x-8': appNotifications, 'translate-x-1': !appNotifications }"></span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function settingsApp() {
            return {
                isDark: localStorage.getItem('darkMode') === 'true',
                appNotifications: true,
                editMode: false,
                currentSection: 'settings',
                userType: 'student',
                notificationsOpen: false,
                unreadNotifications: 3,
                notifications: [
                    { id: 1, title: 'طلب جديد', message: 'تم استلام طلبك رقم #1234', time: 'منذ 5 دقائق' },
                    { id: 2, title: 'عرض خاص', message: 'خصم 20% على جميع الكتب هذا الأسبوع', time: 'منذ ساعة' },
                    { id: 3, title: 'تذكير الحلقة', message: 'حلقة القرآن غداً الساعة 4 عصراً', time: 'منذ يوم' }
                ],
                userData: {
                    first_name: 'محمد',
                    last_name: 'أحمد',
                    phone_number: '0123456789',
                    age: '25',
                    avatar: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='40' r='30' fill='%235C1F25'/%3E%3Ccircle cx='50' cy='100' r='40' fill='%23D4AF37'/%3E%3C/svg%3E"
                },

                init() {
                    // تطبيق وضع التصميم عند التحميل
                    this.toggleDarkMode(this.isDark);
                    console.log("تم تحميل صفحة الإعدادات");

                    // جلب بيانات المستخدم الحالية من الخادم
                    this.fetchUserData();
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

                async fetchUserData() {
                    try {
                        // جلب بيانات المستخدم من الخادم
                        const response = await fetch('/api/user', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + this.getAuthToken()
                            }
                        });

                        if (response.ok) {
                            const userData = await response.json();
                            this.userData = { ...this.userData, ...userData };
                        }
                    } catch (error) {
                        console.error('Error fetching user data:', error);
                    }
                },

                getAuthToken() {
                    // هذه الدالة يجب أن تعيد التوكن من localStorage أو من مكان تخزينه
                    return localStorage.getItem('auth_token') || '';
                },

                previewAvatar(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.userData.avatar = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                async saveProfile() {
                    try {
                        const form = document.getElementById('profileForm');
                        const formData = new FormData(form);

                        // إضافة التوكن للمصادقة
                        const authToken = this.getAuthToken();
                        if (authToken) {
                            formData.append('_token', '{{ csrf_token() }}');
                        }

                        const res = await fetch('/api/student/updatProfile', {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + authToken
                            },
                            body: formData
                        });

                        const data = await res.json();
                        if(data.success){
                            this.showNotification('تم تحديث الملف الشخصي بنجاح', 'success');
                            this.editMode = false;

                            // تحديث البيانات المحلية
                            this.userData.first_name = formData.get('first_name');
                            this.userData.last_name = formData.get('last_name');
                            this.userData.phone_number = formData.get('phone_number');
                            this.userData.age = formData.get('age');
                        } else {
                            this.showNotification(data.message || 'حدث خطأ أثناء تعديل الملف الشخصي', 'error');
                        }
                    } catch(err){
                        console.error(err);
                        this.showNotification('خطأ في الاتصال بالخادم', 'error');
                    }
                },

                showNotification(message, type) {
                    // إنشاء عنصر الإشعار
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} ml-2"></i>
                            <span>${message}</span>
                        </div>
                    `;

                    document.body.appendChild(notification);

                    // إظهار الإشعار
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                    }, 100);

                    // إخفاء الإشعار بعد 3 ثوان
                    setTimeout(() => {
                        notification.classList.add('translate-x-full');
                        setTimeout(() => {
                            document.body.removeChild(notification);
                        }, 300);
                    }, 3000);
                }
            }
        }
    </script>
</body>
</html>
