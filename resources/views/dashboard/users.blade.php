@extends('dashboard.layouts')

@section('content')
<div class="page-transition">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold dark:text-white">إدارة المستخدمين</h2>
        <button class="btn-primary">
            <i class="fas fa-plus ml-2"></i> إضافة مستخدم
        </button>
    </div>

    <!-- بطاقات الإحصاءات -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-300 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-semibold dark:text-white">إجمالي المستخدمين</h3>
                    <p class="text-2xl font-bold dark:text-white">1,234</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-user-check text-green-600 dark:text-green-300 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-semibold dark:text-white">المستخدمين النشطين</h3>
                    <p class="text-2xl font-bold dark:text-white">1,024</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-user-clock text-yellow-600 dark:text-yellow-300 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-semibold dark:text-white">في انتظار التفعيل</h3>
                    <p class="text-2xl font-bold dark:text-white">187</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-user-slash text-red-600 dark:text-red-300 text-xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-lg font-semibold dark:text-white">محظورين</h3>
                    <p class="text-2xl font-bold dark:text-white">23</p>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول المستخدمين -->
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold dark:text-white">قائمة المستخدمين</h3>

            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" placeholder="بحث..." class="bg-gray-100 dark:bg-gray-700 border-0 rounded-lg pl-10 pr-4 py-2 w-64">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>

                <select class="bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-4 py-2">
                    <option>جميع الحالات</option>
                    <option>نشط</option>
                    <option>غير نشط</option>
                    <option>محظور</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="table-header px-6 py-3">المستخدم</th>
                        <th class="table-header px-6 py-3">البريد الإلكتروني</th>
                        <th class="table-header px-6 py-3">الحالة</th>
                        <th class="table-header px-6 py-3">تاريخ التسجيل</th>
                        <th class="table-header px-6 py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=محمد+أحمد&background=0D8ABC&color=fff" alt="">
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">محمد أحمد</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">@moahmed</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">mohamed@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2023-10-15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 ml-4">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900 mr-4">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- المزيد من الصفوف -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=فاطمة+علي&background=F46590&color=fff" alt="">
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">فاطمة علي</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">@fatma</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">fatma@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">معلق</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2023-10-18</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 ml-4">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900 mr-4">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- الترقيم -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700">
            <div class="flex-1 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        عرض
                        <span class="font-medium">1</span>
                        إلى
                        <span class="font-medium">10</span>
                        من
                        <span class="font-medium">97</span>
                        نتائج
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="sr-only">السابق</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 dark:bg-blue-900 text-sm font-medium text-blue-600 dark:text-blue-100 border-blue-500 dark:border-blue-700">1</a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">2</a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">3</a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="sr-only">التالي</span>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
