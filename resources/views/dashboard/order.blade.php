<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلبات | لوحة التحكم</title>
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
                        },
                        success: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        },
                        warning: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        },
                        danger: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                        }
                    },
                    fontFamily: {
                        'arabic': ['Tajawal', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Tajawal (Arabic) -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .btn-primary {
            background-color: #0284c7;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary:hover {
            background-color: #0369a1;
        }
        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .dark .card {
            background-color: #1f2937;
            border-color: #374151;
        }
        .table-header {
            background-color: #f9fafb;
            text-align: right;
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1.5rem;
        }
        .dark .table-header {
            background-color: #374151;
            color: #d1d5db;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }
        .dark .badge-success {
            background-color: #14532d;
            color: #bbf7d0;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .dark .badge-warning {
            background-color: #78350f;
            color: #fde68a;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .dark .badge-danger {
            background-color: #7f1d1d;
            color: #fecaca;
        }
        .badge-info {
            background-color: #e0f2fe;
            color: #0c4a6e;
        }
        .dark .badge-info {
            background-color: #0c4a6e;
            color: #bae6fd;
        }
        .shadow-custom {
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .dark .shadow-custom {
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-200" x-data="ordersPage()">
    <div class="container mx-auto px-4 py-8">
        <!-- عناصر تحكم الصفحة -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold dark:text-white">إدارة الطلبات</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">عرض ومتابعة جميع الطلبات في النظام</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <div class="relative">
                    <select class="block w-full pl-10 pr-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" x-model="filterStatus">
                        <option value="all">جميع الطلبات</option>
                        <option value="pending">قيد الانتظار</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="completed">مكتملة</option>
                        <option value="cancelled">ملغاة</option>
                    </select>
                    <i class="fas fa-filter absolute right-3 top-3 text-gray-400"></i>
                </div>
                <button class="btn-primary">
                    <i class="fas fa-download ml-2"></i>
                    تصدير البيانات
                </button>
            </div>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-primary-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-100 dark:bg-primary-900/30 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-primary-600 dark:text-primary-400 text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">42</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-warning-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-warning-100 dark:bg-warning-900/30 p-3 rounded-lg">
                        <i class="fas fa-clock text-warning-600 dark:text-warning-400 text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">12</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">طلبات قيد الانتظار</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-success-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-success-100 dark:bg-success-900/30 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-success-600 dark:text-success-400 text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">25</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">طلبات مكتملة</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-danger-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-danger-100 dark:bg-danger-900/30 p-3 rounded-lg">
                        <i class="fas fa-times-circle text-danger-600 dark:text-danger-400 text-xl"></i>
                    </div>
                    <div class="mr-4">
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white">5</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">طلبات ملغاة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الطلبات -->
        <div class="card">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white">قائمة الطلبات</h3>

                <div class="flex mt-4 md:mt-0">
                    <div class="relative">
                        <input type="text" placeholder="بحث..." class="pr-10 pl-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" x-model="searchQuery">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="table-header px-6 py-3">رقم الطلب</th>
                            <th class="table-header px-6 py-3">العميل</th>
                            <th class="table-header px-6 py-3">تاريخ الطلب</th>
                            <th class="table-header px-6 py-3">المبلغ</th>
                            <th class="table-header px-6 py-3">الحالة</th>
                            <th class="table-header px-6 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="order in filteredOrders" :key="order.id">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200" x-text="'#' + order.id"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" :src="order.customer.avatar" :alt="order.customer.name">
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="order.customer.name"></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="order.customer.email"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200" x-text="order.date"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200" x-text="order.amount + ' ريال'"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template x-if="order.status === 'completed'">
                                        <span class="badge badge-success">مكتمل</span>
                                    </template>
                                    <template x-if="order.status === 'pending'">
                                        <span class="badge badge-warning">قيد الانتظار</span>
                                    </template>
                                    <template x-if="order.status === 'processing'">
                                        <span class="badge badge-info">قيد المعالجة</span>
                                    </template>
                                    <template x-if="order.status === 'cancelled'">
                                        <span class="badge badge-danger">ملغي</span>
                                    </template>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300" @click="viewOrder(order)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300" @click="editOrder(order)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300" @click="deleteOrder(order)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    عرض <span class="font-medium" x-text="filteredOrders.length"></span> من <span class="font-medium" x-text="orders.length"></span> نتائج
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600" :disabled="currentPage === 1" @click="currentPage--">
                        السابق
                    </button>
                    <button class="px-3 py-1.5 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700" x-text="currentPage"></button>
                    <button class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600" @click="currentPage++">
                        التالي
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج عرض تفاصيل الطلب -->
    <div x-show="showOrderDetails" class="fixed inset-0 overflow-y-auto z-50" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full" @click.outside="showOrderDetails = false">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:mr-4 sm:text-right w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" x-text="'تفاصيل الطلب #' + selectedOrder.id"></h3>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">معلومات العميل</h4>
                                    <p x-text="selectedOrder.customer.name"></p>
                                    <p class="text-gray-500 dark:text-gray-400" x-text="selectedOrder.customer.email"></p>
                                    <p class="text-gray-500 dark:text-gray-400" x-text="selectedOrder.customer.phone"></p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-800 dark:text-white mb-2">معلومات الطلب</h4>
                                    <p x-text="'تاريخ الطلب: ' + selectedOrder.date"></p>
                                    <p x-text="'الحالة: ' + getStatusText(selectedOrder.status)"></p>
                                    <p x-text="'المبلغ: ' + selectedOrder.amount + ' ريال'"></p>
                                </div>
                            </div>

                            <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">المنتجات</h4>
                                <template x-for="product in selectedOrder.products" :key="product.id">
                                    <div class="flex justify-between items-center py-2 border-b dark:border-gray-600">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-md object-cover" :src="product.image" :alt="product.name">
                                            <div class="mr-3">
                                                <p class="text-sm font-medium text-gray-800 dark:text-white" x-text="product.name"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="'الكمية: ' + product.quantity"></p>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-800 dark:text-white" x-text="product.price + ' ريال'"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="btn-primary mt-3 sm:mt-0 sm:ml-3" @click="showOrderDetails = false">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function ordersPage() {
            return {
                searchQuery: '',
                filterStatus: 'all',
                currentPage: 1,
                showOrderDetails: false,
                selectedOrder: {},
                orders: [
                    {
                        id: 1001,
                        customer: {
                            name: 'أحمد محمد',
                            email: 'ahmed@example.com',
                            phone: '+966 123 456 789',
                            avatar: 'https://ui-avatars.com/api/?name=أحمد+محمد&background=0D8ABC&color=fff'
                        },
                        date: '2023-10-15',
                        amount: 450,
                        status: 'completed',
                        products: [
                            { id: 1, name: 'دورة القرآن للمبتدئين', price: 300, quantity: 1, image: 'https://via.placeholder.com/40' },
                            { id: 2, name: 'كتاب تعليم التجويد', price: 150, quantity: 1, image: 'https://via.placeholder.com/40' }
                        ]
                    },
                    {
                        id: 1002,
                        customer: {
                            name: 'فاطمة علي',
                            email: 'fatima@example.com',
                            phone: '+966 987 654 321',
                            avatar: 'https://ui-avatars.com/api/?name=فاطمة+علي&background=10B981&color=fff'
                        },
                        date: '2023-11-02',
                        amount: 200,
                        status: 'pending',
                        products: [
                            { id: 3, name: 'دورة التلاوة المتقدمة', price: 200, quantity: 1, image: 'https://via.placeholder.com/40' }
                        ]
                    },
                    {
                        id: 1003,
                        customer: {
                            name: 'محمد خالد',
                            email: 'mohamed@example.com',
                            phone: '+966 555 123 456',
                            avatar: 'https://ui-avatars.com/api/?name=محمد+خالد&background=F59E0B&color=fff'
                        },
                        date: '2023-09-20',
                        amount: 600,
                        status: 'processing',
                        products: [
                            { id: 4, name: 'باقة القرآن الكاملة', price: 600, quantity: 1, image: 'https://via.placeholder.com/40' }
                        ]
                    },
                    {
                        id: 1004,
                        customer: {
                            name: 'سارة عبدالله',
                            email: 'sara@example.com',
                            phone: '+966 111 222 333',
                            avatar: 'https://ui-avatars.com/api/?name=سارة+عبدالله&background=EC4899&color=fff'
                        },
                        date: '2023-11-05',
                        amount: 150,
                        status: 'cancelled',
                        products: [
                            { id: 2, name: 'كتاب تعليم التجويد', price: 150, quantity: 1, image: 'https://via.placeholder.com/40' }
                        ]
                    }
                ],
                get filteredOrders() {
                    let result = this.orders;

                    // Filter by status
                    if (this.filterStatus !== 'all') {
                        result = result.filter(order => order.status === this.filterStatus);
                    }

                    // Search filter
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        result = result.filter(order =>
                            order.id.toString().includes(query) ||
                            order.customer.name.toLowerCase().includes(query) ||
                            order.customer.email.toLowerCase().includes(query)
                        );
                    }

                    return result;
                },
                viewOrder(order) {
                    this.selectedOrder = order;
                    this.showOrderDetails = true;
                },
                editOrder(order) {
                    alert('تعديل الطلب: #' + order.id);
                },
                deleteOrder(order) {
                    if (confirm('هل أنت متأكد من حذف الطلب #' + order.id + '؟')) {
                        this.orders = this.orders.filter(o => o.id !== order.id);
                    }
                },
                getStatusText(status) {
                    const statusMap = {
                        'pending': 'قيد الانتظار',
                        'processing': 'قيد المعالجة',
                        'completed': 'مكتمل',
                        'cancelled': 'ملغي'
                    };
                    return statusMap[status] || status;
                }
            }
        }
    </script>
</body>
</html>
