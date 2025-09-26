<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="loginPage()" :class="{ 'dark': isDark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول | نظام إدارة مسجد الخانقية</title>

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

        .auth-bg {
            background: linear-gradient(135deg, #5C1F25 0%, #3E1419 50%, #1F0A0D 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .dark .auth-bg {
            background: linear-gradient(135deg, #1F0A0D 0%, #2F0F13 50%, #3E1419 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid rgba(92, 31, 37, 0.1);
        }

        .card-hover:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 25px 50px -12px rgba(92, 31, 37, 0.25);
            border-color: rgba(92, 31, 37, 0.2);
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .pulse-ring {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(92, 31, 37, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 20px rgba(92, 31, 37, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(92, 31, 37, 0); }
        }

        .gradient-text {
            background: linear-gradient(135deg, #5C1F25 0%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .golden-gradient-text {
            background: linear-gradient(135deg, #D4AF37 0%, #E6C875 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .islamic-pattern {
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .btn-primary {
            background: linear-gradient(135deg, #5C1F25 0%, #3E1419 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4A191F 0%, #2F0F13 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(92, 31, 37, 0.4);
        }

        .btn-golden {
            background: linear-gradient(135deg, #D4AF37 0%, #C19C30 100%);
            color: #1F0A0D;
            transition: all 0.3s ease;
        }

        .btn-golden:hover {
            background: linear-gradient(135deg, #C19C30 0%, #A68528 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(212, 175, 55, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-2px);
        }

        .dark .btn-secondary {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
        }

        .dark .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        }

        .quranic-verse {
            font-family: 'Scheherazade New', serif;
            line-height: 2.2;
            text-align: center;
            font-size: 1.5rem;
            color: #D4AF37;
            margin: 2rem 0;
            padding: 1.5rem;
            border-radius: 1rem;
            background: rgba(92, 31, 37, 0.1);
            border-right: 4px solid #D4AF37;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen font-arabic transition-colors duration-300" x-cloak>
    <!-- عناصر الزخرفة العائمة -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-20 h-20 bg-primary-500/10 rounded-full floating-element"></div>
        <div class="absolute bottom-40 right-20 w-16 h-16 bg-golden-400/10 rounded-full floating-element" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-primary-600/10 rounded-full floating-element" style="animation-delay: 4s;"></div>
    </div>

    <div class="min-h-screen flex relative">
        <!-- الجانب الأيسر: صورة وصفحة ترحيبية -->
        <div class="hidden lg:flex lg:w-1/2 auth-bg items-center justify-center p-12 text-white relative">
            <div class="absolute top-8 left-8">
                <div class="pulse-ring w-16 h-16 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23D4AF37' d='M50 10L15 50l35 40 35-40z'/%3E%3Ccircle fill='%235C1F25' cx='50' cy='50' r='20'/%3E%3Cpath fill='%23D4AF37' d='M50 40l5 15h10l-8 6 3 15-10-8-10 8 3-15-8-6h10z'/%3E%3C/svg%3E" alt="شعار مسجد الخانقية" class="w-8 h-8">
                </div>
            </div>

            <div class="max-w-md text-center relative z-10">
                <div class="mb-8">
                    <div class="w-24 h-24 mx-auto bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23D4AF37' d='M50 10L15 50l35 40 35-40z'/%3E%3Ccircle fill='%235C1F25' cx='50' cy='50' r='20'/%3E%3Cpath fill='%23D4AF37' d='M50 40l5 15h10l-8 6 3 15-10-8-10 8 3-15-8-6h10z'/%3E%3C/svg%3E" alt="شعار مسجد الخانقية" class="w-16 h-16">
                    </div>
                </div>

                <h1 class="text-5xl font-bold mb-6 font-quranic golden-gradient-text">مسجد الخانقية</h1>
                <p class="text-xl opacity-90 mb-8 leading-relaxed text-golden-300">منصة متكاملة لإدارة الحلقات القرآنية والتعليمية</p>

                <!-- الآية القرآنية -->
                <div class="quranic-verse">
                    <p class="font-elegant">يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ</p>
                    <p class="text-white text-sm mt-2">(سورة المجادلة، الآية: 11)</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-golden-400/20">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-golden-400/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-golden-300"></i>
                            </div>
                            <span class="text-lg text-golden-100">إدارة الحلقات القرآنية</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-golden-400/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-golden-300"></i>
                            </div>
                            <span class="text-lg text-golden-100">متابعة تقدم الطلاب</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-golden-400/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-golden-300"></i>
                            </div>
                            <span class="text-lg text-golden-100">تقارير وإحصائيات مفصلة</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-center space-x-4">
                        <div class="w-2 h-2 bg-golden-400/60 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                        <div class="w-2 h-2 bg-golden-400/60 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                        <div class="w-2 h-2 bg-golden-400/60 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    </div>
                </div>
            </div>

            <!-- الزخرفة الإسلامية -->
            <div class="absolute bottom-0 left-0 right-0 h-20 islamic-pattern opacity-50"></div>
        </div>

        <!-- الجانب الأيمن: نموذج تسجيل الدخول -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-6 md:p-12 relative">
            <div class="w-full max-w-md">
                <!-- شعار الموبايل -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-500 to-primary-700 rounded-3xl flex items-center justify-center shadow-custom mb-6">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cpath fill='%23D4AF37' d='M50 10L15 50l35 40 35-40z'/%3E%3Ccircle fill='%235C1F25' cx='50' cy='50' r='20'/%3E%3Cpath fill='%23D4AF37' d='M50 40l5 15h10l-8 6 3 15-10-8-10 8 3-15-8-6h10z'/%3E%3C/svg%3E" alt="شعار مسجد الخانقية" class="w-12 h-12">
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white font-quranic gradient-text">مسجد الخانقية</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">سجل الدخول إلى حسابك للمتابعة</p>
                </div>

                <!-- بطاقة تسجيل الدخول -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-custom dark:shadow-custom-dark card-hover p-8 backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                    <!-- أزرار اختيار نوع المستخدم -->
                    <div class="flex mb-8 bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                        <button
                            @click="currentForm = 'student'"
                            :class="currentForm === 'student' ?
                                'bg-white dark:bg-gray-800 text-primary-600 shadow-lg' :
                                'text-gray-600 dark:text-gray-300 hover:text-primary-500'"
                            class="flex-1 py-4 px-6 rounded-xl font-semibold transition-all duration-300 focus:outline-none transform hover:scale-105"
                            style="transition-property: transform, background-color, color;">
                            <i class="fas fa-user-graduate ml-2"></i>
                            طالب
                        </button>
                        <button
                            @click="currentForm = 'teacher'"
                            :class="currentForm === 'teacher' ?
                                'bg-white dark:bg-gray-800 text-primary-600 shadow-lg' :
                                'text-gray-600 dark:text-gray-300 hover:text-primary-500'"
                            class="flex-1 py-4 px-6 rounded-xl font-semibold transition-all duration-300 focus:outline-none transform hover:scale-105"
                            style="transition-property: transform, background-color, color;">
                            <i class="fas fa-chalkboard-teacher ml-2"></i>
                            معلم
                        </button>
                    </div>

                    <!-- نموذج تسجيل الدخول للطالب -->
                    <form x-show="currentForm === 'student'" @submit.prevent="studentLogin()" class="space-y-6">
                        <div>
                            <label for="student_phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">اسم المستخدم</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z_10">
                                    <i class="fas fa-user text-golden-500"></i>
                                </div>
                                <input
                                    type="text"
                                    id="student_name"
                                    x-model="studentData.phone_number"
                                    required
                                    class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-all duration-300"
                                    placeholder="   أدخل رقم المستخدم">
                            </div>
                        </div>

                        <div>
                            <label for="student_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">كلمة المرور</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z-10">
                                    <i class="fas fa-lock text-golden-500"></i>
                                </div>
                                <input
                                    type="password"
                                    id="student_password"
                                    x-model="studentData.password"
                                    required
                                    class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-all duration-300"
                                    placeholder="   أدخل كلمة المرور">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input
                                    id="remember-student"
                                    type="checkbox"
                                    class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition">
                                <span class="mr-2 block text-sm text-gray-700 dark:text-gray-300">تذكرني</span>
                            </label>

                            <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-semibold transition-colors">
                                نسيت كلمة المرور؟
                            </a>
                        </div>

                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full btn-primary text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500/20 flex items-center justify-center space-x-2"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : 'hover:shadow-lg transform hover:-translate-y-0.5'">
                            <span x-show="!loading">تسجيل الدخول</span>
                            <span x-show="loading">جاري تسجيل الدخول...</span>
                            <i class="fas fa-arrow-left" x-show="!loading"></i>
                            <i class="fas fa-circle-notch fa-spin" x-show="loading"></i>
                        </button>
                    </form>

               <!-- نموذج تسجيل الدخول للمعلم -->
<form x-show="currentForm === 'teacher'" @submit.prevent="teacherLogin()" class="space-y-6">
    <div>
        <label for="teacher_phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">رقم الهاتف</label>
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z-10">
                <i class="fas fa-phone text-golden-500"></i> <!-- تغيير الأيقونة إلى هاتف -->
            </div>
            <input
                type="text"
                id="teacher_phone_number"
                x-model="teacherData.phone_number"
                required
                class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-all duration-300"
                placeholder="أدخل رقم الهاتف">
        </div>
    </div>

    <div>
        <label for="teacher_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">كلمة المرور</label>
        <div class="relative">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none z-10">
                <i class="fas fa-lock text-golden-500"></i>
            </div>
            <input
                type="password"
                id="teacher_password"
                x-model="teacherData.password"
                required
                class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition-all duration-300"
                placeholder="أدخل كلمة المرور">
        </div>
    </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input
                                    id="remember-teacher"
                                    type="checkbox"
                                    class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition">
                                <span class="mr-2 block text-sm text-gray-700 dark:text-gray-300">تذكرني</span>
                            </label>

                            <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-semibold transition-colors">
                                نسيت كلمة المرور؟
                            </a>
                        </div>

                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full btn-primary text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500/20 flex items-center justify-center space-x-2"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : 'hover:shadow-lg transform hover:-translate-y-0.5'">
                            <span x-show="!loading">تسجيل الدخول</span>
                            <span x-show="loading">جاري تسجيل الدخول...</span>
                            <i class="fas fa-arrow-left" x-show="!loading"></i>
                            <i class="fas fa-circle-notch fa-spin" x-show="loading"></i>
                        </button>
                    </form>

                    <!-- تسجيل الدخول باستخدام حسابات أخرى -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-3 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-medium">أو</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <button class="btn-secondary py-3 px-4 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2 hover:shadow-md">
                                <i class="fab fa-google text-red-500"></i>
                                <span>Google</span>
                            </button>

                            <button class="btn-secondary py-3 px-4 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2 hover:shadow-md">
                                <i class="fab fa-microsoft text-blue-500"></i>
                                <span>Microsoft</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- رابط إنشاء حساب جديد -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 dark:text-gray-300">
                        ليس لديك حساب؟
                        <button @click="showRegisterModal = true" class="text-primary-600 font-semibold hover:text-primary-500 transition-colors ml-1">
                            إنشاء حساب جديد
                        </button>
                    </p>
                </div>

                <!-- تبديل وضع الظلام -->
                <div class="mt-6 flex justify-center">
                    <button @click="toggleDarkMode()" class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center transition-all duration-300 hover:shadow-lg hover:scale-110">
                        <i class="fas text-lg transition-all duration-300" :class="isDark ? 'fa-sun text-golden-400' : 'fa-moon text-gray-600'"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة إنشاء حساب جديد -->
    <div x-show="showRegisterModal" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">إنشاء حساب جديد</h3>
                    <button @click="showRegisterModal = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- أزرار اختيار نوع الحساب -->
                <div class="flex mb-5 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                    <button
                        @click="registerType = 'student'"
                        :class="registerType === 'student' ?
                            'bg-white dark:bg-gray-800 text-primary-600 shadow-sm' :
                            'text-gray-600 dark:text-gray-300'"
                        class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 focus:outline-none">
                        طالب
                    </button>
                    <button
                        @click="registerType = 'teacher'"
                        :class="registerType === 'teacher' ?
                            'bg-white dark:bg-gray-800 text-primary-600 shadow-sm' :
                            'text-gray-600 dark:text-gray-300'"
                        class="flex-1 py-2 px-4 rounded-lg font-medium transition-all duration-300 focus:outline-none">
                        معلم
                    </button>
                </div>

                <!-- نموذج تسجيل الطالب -->
                <form x-show="registerType === 'student'" @submit.prevent="registerStudent()" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المعلم</label>
                        <select x-model="registerStudentData.teacher_id" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                            <option value="">اختر المعلم</option>
                            <template x-for="teacher in teachers" :key="teacher.id">
                                <option :value="teacher.id" x-text="teacher.first_name + ' ' + teacher.last_name"></option>
                            </template>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الأول</label>
                            <input type="text" x-model="registerStudentData.first_name" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الأخير</label>
                            <input type="text" x-model="registerStudentData.last_name" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم المستخدم</label>
                        <input type="text" x-model="registerStudentData.student_name" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الهاتف</label>
                            <input type="text" x-model="registerStudentData.phone_number" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">العمر</label>
                            <input type="number" x-model="registerStudentData.age" min="5" max="25" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">كلمة المرور</label>
                        <input type="password" x-model="registerStudentData.password" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                    </div>
           <button
                        type="submit"
                        :disabled="loading"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center"
                        :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                        <span x-show="!loading">إنشاء حساب طالب</span>
                        <span x-show="loading">جاري إنشاء الحساب...</span>
                        <i class="fas fa-circle-notch fa-spin ml-2" x-show="loading"></i>
                    </button>
                </form>

                  <!-- نموذج تسجيل المعلم (المعدل) -->
                <form x-show="registerType === 'teacher'" @submit.prevent="registerTeacher()" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الأول</label>
                            <input type="text" x-model="registerTeacherData.first_name" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الأخير</label>
                            <input type="text" x-model="registerTeacherData.last_name" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الهاتف</label>
                        <input type="text" x-model="registerTeacherData.phone_number" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition"
                               placeholder="يجب أن يكون مسجلاً مسبقاً في قائمة المعلمين">
                    </div>

                    <!-- حقل الكود المضاف -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الكود</label>
                        <input type="text" x-model="registerTeacherData.code" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition"
                               placeholder="أدخل الكود المخصص لك">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">يجب أن يتطابق مع الكود المسجل في قائمة المعلمين</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">كلمة المرور</label>
                        <input type="password" x-model="registerTeacherData.password" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                    </div>

                    <!-- حقل الصورة الشخصية (اختياري) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الصورة الشخصية (اختياري)</label>
                        <input type="file" id="teacher_avatar" @change="handleTeacherAvatar"
                               accept="image/jpg,image/jpeg,image/png"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">الصيغ المسموحة: JPG, JPEG, PNG</p>
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-lg font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center"
                        :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                        <span x-show="!loading">إنشاء حساب معلم</span>
                        <span x-show="loading">جاري إنشاء الحساب...</span>
                        <i class="fas fa-circle-notch fa-spin ml-2" x-show="loading"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

   <script>
    function loginPage() {
        return {
            currentForm: 'student',
            isDark: localStorage.getItem('darkMode') === 'true',
            loading: false,
            showRegisterModal: false,
            registerType: 'student',
            teachers: [],

       // بيانات تسجيل الدخول
studentData: {
    student_name: '',
    password: ''
},
teacherData: {
    phone_number: '', // سيتم استخدام رقم الهاتف للتسجيل
    password: ''
},
            // بيانات تسجيل الحساب
            registerStudentData: {
                teacher_id: '',
                first_name: '',
                last_name: '',
                student_name: '',
                phone_number: '',
                age: '',
                password: ''
            },
            registerTeacherData: {
                first_name: '',
                last_name: '',
                phone_number: '',
                code: '',
                password: '',
                avatar: null
            },

            init() {
                // تطبيق وضع التصميم عند التحميل
                this.toggleDarkMode(this.isDark);

                // جلب قائمة المعلمين عند فتح نافذة التسجيل
                this.$watch('showRegisterModal', (value) => {
                    if (value && this.registerType === 'student') {
                        this.fetchTeachers();
                    }
                });

                // عند تغيير نوع التسجيل، جلب المعلمين إذا كان طالباً
                this.$watch('registerType', (value) => {
                    if (value === 'student') {
                        this.fetchTeachers();
                    }
                });
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

async fetchTeachers() {
    try {
        console.log('=== بدء جلب المعلمين ===');

        const response = await fetch('/api/teacher/teachers');
        console.log('حالة HTTP:', response.status, response.statusText);

        // تحقق من نوع المحتوى
        const contentType = response.headers.get('content-type');
        console.log('نوع المحتوى:', contentType);

        const responseText = await response.text();
        console.log('النص الكامل للرد:', responseText);

        if (!response.ok) {
            throw new Error(`خطأ HTTP: ${response.status} ${response.statusText}`);
        }

        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('الخادم لم يرجع JSON');
        }

        const data = JSON.parse(responseText);
        console.log('البيانات بعد التحليل:', data);

        if (data.success) {
            this.teachers = data.teachers;
            const count = data.count || data.teachers.length;
            this.showNotification(`تم تحميل ${count} معلم بنجاح`, 'success');
        } else {
            throw new Error(data.message || 'الخادم رجع success: false');
        }

    } catch (error) {
        console.error('❌ تفاصيل الخطأ الكاملة:', error);
        this.showNotification('خطأ في جلب بيانات المعلمين', 'error');
        this.teachers = [];

        // بيانات تجريبية للاستمرار
        this.teachers = [
            { id: 1, first_name: 'أحمد', last_name: 'محمد' },
            { id: 2, first_name: 'محمد', last_name: 'علي' }
        ];
    }
},

        async teacherLogin() {
    this.loading = true;

    try {
        const response = await fetch('/api/teacher/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(this.teacherData)
        });

        const data = await response.json();

        if (data.success) {
            localStorage.setItem('token', data.token);
            localStorage.setItem('user', JSON.stringify(data.teacher));
            localStorage.setItem('user_type', 'teacher');
            this.showNotification('تم تسجيل الدخول بنجاح', 'success');

            // التوجيه إلى الصفحة الرئيسية
            setTimeout(() => {
               localStorage.setItem("auth_token", data.token);
window.location.href = "products.html";

            }, 1000);
        } else {
            this.showNotification(data.message || 'خطأ في تسجيل الدخول', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        this.showNotification('حدث خطأ أثناء تسجيل الدخول', 'error');
    }

    this.loading = false;
},

//          async teacherLogin() {
//     this.loading = true;

//     try {
//         const response = await fetch('/api/teacher/login', {
//             method: 'POST', // تأكد أنه POST
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//                 'Accept': 'application/json'
//             },
//             body: JSON.stringify(this.teacherData)
//         });

//         // تحقق من نوع المحتوى
//         const contentType = response.headers.get('content-type');
//         console.log('نوع المحتوى:', contentType);

//         if (!contentType || !contentType.includes('application/json')) {
//             const text = await response.text();
//             console.log('الرد غير JSON:', text.substring(0, 200));
//             throw new Error('الخادم أرجع HTML بدلاً من JSON - تأكد من الـ route');
//         }

//         const data = await response.json();
//         console.log('بيانات الرد:', data);

//         if (data.success) {
//             localStorage.setItem('token', data.token);
//             localStorage.setItem('user', JSON.stringify(data.teacher));
//             localStorage.setItem('user_type', 'teacher');
//             this.showNotification('تم تسجيل الدخول بنجاح', 'success');

//             setTimeout(() => {
//                 window.location.href = '/teacher/dashboard';
//             }, 1000);
//         } else {
//             this.showNotification(data.message || 'خطأ في تسجيل الدخول', 'error');
//         }
//     } catch (error) {
//         console.error('تفاصيل الخطأ:', error);
//         this.showNotification('خطأ في الاتصال: ' + error.message, 'error');
//     }

//     this.loading = false;
// },

          async registerStudent() {
    this.loading = true;

    try {
        const formData = new FormData();
        for (const key in this.registerStudentData) {
            formData.append(key, this.registerStudentData[key]);
        }

        const response = await fetch('/api/student/register', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            this.showNotification('تم إنشاء حساب الطالب بنجاح', 'success');
            this.showRegisterModal = false;

            // تسجيل الدخول تلقائياً بعد التسجيل
            this.studentData.student_name = this.registerStudentData.student_name;
            this.studentData.password = this.registerStudentData.password;

            // انتظار قليل ثم تسجيل الدخول
              setTimeout(() => {
                console.log('🔄 جاري التوجيه إلى الصفحة الرئيسية...'); // 🔍 اضف هذا
                window.location.href = '/';
            }, 1000);
        } else {
            this.showNotification(data.message || 'خطأ في تسجيل الدخول', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        this.showNotification('حدث خطأ أثناء تسجيل الدخول', 'error');
    }

    this.loading = false;
},
async studentLogin() {
    this.loading = true;
    try {
        const response = await fetch('/api/student/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(this.studentData)
        });

        const data = await response.json();

        if (data.success) {
            // استخدم auth_token بدلاً من token
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user', JSON.stringify(data.student));
            localStorage.setItem('user_type', 'student');
            this.showNotification('تم تسجيل الدخول بنجاح', 'success');

            // تأكد من المسار الصحيح
            setTimeout(() => {
                window.location.href = '/products'; // تأكد من هذا المسار
            }, 1000);
        } else {
            this.showNotification(data.message || 'خطأ في تسجيل الدخول', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        this.showNotification('حدث خطأ أثناء تسجيل الدخول', 'error');
    }
    this.loading = false;
},

            // دالة التعامل مع رفع الصورة الشخصية للمعلم
            handleTeacherAvatar(event) {
                const file = event.target.files[0];
                if (file) {
                    // التحقق من نوع الملف
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        this.showNotification('نوع الملف غير مسموح. المسموح: JPG, JPEG, PNG', 'error');
                        event.target.value = '';
                        this.registerTeacherData.avatar = null;
                        return;
                    }

                    // التحقق من حجم الملف (5MB كحد أقصى)
                    if (file.size > 5 * 1024 * 1024) {
                        this.showNotification('حجم الملف كبير جداً. الحد الأقصى 5MB', 'error');
                        event.target.value = '';
                        this.registerTeacherData.avatar = null;
                        return;
                    }

                    this.registerTeacherData.avatar = file;
                    this.showNotification('تم اختيار الصورة بنجاح', 'success');
                } else {
                    this.registerTeacherData.avatar = null;
                }
            }, // تم إضافة القوس هنا

         async registerTeacher() {
    this.loading = true;

    try {
        // إنشاء FormData
        const formData = new FormData();
        formData.append('first_name', this.registerTeacherData.first_name);
        formData.append('last_name', this.registerTeacherData.last_name);
        formData.append('phone_number', this.registerTeacherData.phone_number);
        formData.append('code', this.registerTeacherData.code);
        formData.append('password', this.registerTeacherData.password);

        if (this.registerTeacherData.avatar) {
            formData.append('avatar', this.registerTeacherData.avatar);
        }

        // الحصول على CSRF token
        await fetch('/sanctum/csrf-cookie', {
            method: 'GET',
            credentials: 'include'
        });

        // إرسال الطلب
        const response = await fetch('/api/teacher/register', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            this.showNotification('تم إنشاء حساب المعلم بنجاح', 'success');
            this.showRegisterModal = false;

            // تسجيل الدخول تلقائياً بعد التسجيل
            this.teacherData.phone_number = this.registerTeacherData.phone_number;
            this.teacherData.password = this.registerTeacherData.password;

            // انتظار قليل ثم تسجيل الدخول
              setTimeout(() => {
                console.log('🔄 جاري التوجيه إلى الصفحة الرئيسية...'); // 🔍 اضف هذا
                window.location.href = '/';
            }, 1000);
        } else {
            this.showNotification(data.message || 'خطأ في تسجيل الدخول', 'error');
        }
    } catch (error) {
        console.error('Login error:', error);
        this.showNotification('حدث خطأ أثناء تسجيل الدخول', 'error');
    }

    this.loading = false;
},

            showNotification(message, type = 'info') {
                // إنشاء عنصر الإشعار
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white font-medium transition transform duration-300 ${
                    type === 'success' ? 'bg-green-500' :
                    type === 'error' ? 'bg-red-500' :
                    'bg-blue-500'
                }`;
                notification.textContent = message;
                notification.style.transform = 'translateX(100%)';

                // إضافة الإشعار إلى الصفحة
                document.body.appendChild(notification);

                // إظهار الإشعار
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                // إخفاء الإشعار بعد 3 ثوان
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
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
