<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h3 class="text-lg font-medium text-gray-800 dark:text-white">قائمة الطلاب</h3>

        <div class="flex mt-4 md:mt-0 space-x-3">
            <div class="relative">
                <select class="block w-full pl-10 pr-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option>فرز حسب</option>
                    <option>الأحدث</option>
                    <option>الأقدم</option>
                    <option>الأبجدي</option>
                </select>
                <i class="fas fa-sort absolute right-3 top-3 text-gray-400"></i>
            </div>

            <button class="btn-primary">
                <i class="fas fa-plus ml-2"></i>
                إضافة طالب
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr>
                    <th class="table-header px-6 py-3">#</th>
                    <th class="table-header px-6 py-3">الطالب</th>
                    <th class="table-header px-6 py-3">البريد الإلكتروني</th>
                    <th class="table-header px-6 py-3">الحلقة</th>
                    <th class="table-header px-6 py-3">الحالة</th>
                    <th class="table-header px-6 py-3">تاريخ التسجيل</th>
                    <th class="table-header px-6 py-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">1</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=أحمد+محمد&background=0D8ABC&color=fff" alt="">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">أحمد محمد</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">+966 123 456 789</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">ahmed@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">الحلقة الأولى</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="badge badge-success">نشط</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">2023-10-15</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">2</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=فاطمة+علي&background=10B981&color=fff" alt="">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">فاطمة علي</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">+966 987 654 321</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">fatima@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">الحلقة الثانية</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="badge badge-warning">معلق</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">2023-11-02</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">3</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=محمد+خالد&background=F59E0B&color=fff" alt="">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">محمد خالد</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">+966 555 123 456</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">mohamed@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">الحلقة الثالثة</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="badge badge-success">نشط</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">2023-09-20</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            عرض <span class="font-medium">1</span> إلى <span class="font-medium">3</span> من <span class="font-medium">42</span> نتائج
        </div>
        <div class="flex space-x-2">
            <button class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                السابق
            </button>
            <button class="px-3 py-1.5 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                1
            </button>
            <button class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                2
            </button>
            <button class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                التالي
            </button>
        </div>
    </div>
</div>
