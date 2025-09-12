<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المطاعم</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        .btn-primary {
            background-color: #0284c7;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #0369a1;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        .restaurant-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .restaurant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* تخصيص شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5a5a5;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .closed {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .open {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .low-capacity {
            background-color: #fef3c7;
            color: #d97706;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- شريط التنقل -->
    <nav class="bg-white shadow-md py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-primary-700 flex items-center">
                <i class="fas fa-utensils ml-2"></i>
                إدارة المطاعم
            </h1>

            <div class="flex items-center space-x-4">
                <button id="addRestaurantBtn" class="btn-primary flex items-center">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة مطعم
                </button>

                <div class="relative">
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                        <img src="https://ui-avatars.com/api/?name=مدير+النظام&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full" alt="Profile">
                        <span>مدير النظام</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- محتوى الصفحة -->
    <div class="container mx-auto px-4 py-6">
        <!-- عناصر التحكم -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold">قائمة المطاعم</h2>
                <p class="text-gray-500 mt-1">إدارة وعرض جميع المطاعم في النظام</p>
            </div>

            <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0 mt-4 md:mt-0">
                <div class="relative">
                    <input type="text" placeholder="بحث عن مطعم..." class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع الحالات</option>
                    <option value="open">مفتوح</option>
                    <option value="closed">مغلق</option>
                </select>
            </div>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="card flex items-center justify-between">
                <div>
                    <p class="text-gray-500">إجمالي المطاعم</p>
                    <h3 class="text-2xl font-bold" id="totalRestaurants">25</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-utensils text-blue-600 text-xl"></i>
                </div>
            </div>

            <div class="card flex items-center justify-between">
                <div>
                    <p class="text-gray-500">المطاعم النشطة</p>
                    <h3 class="text-2xl font-bold" id="activeRestaurants">18</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>

            <div class="card flex items-center justify-between">
                <div>
                    <p class="text-gray-500">مطاعم مغلقة</p>
                    <h3 class="text-2xl font-bold" id="closedRestaurants">4</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>

            <div class="card flex items-center justify-between">
                <div>
                    <p class="text-gray-500">الحجوزات اليوم</p>
                    <h3 class="text-2xl font-bold" id="todayReservations">42</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- شبكة المطاعم -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="restaurantsGrid">
            <!-- سيتم ملء هذه المنطقة بالمطاعم ديناميكيًا -->
        </div>

        <!-- الترقيم -->
        <div class="flex justify-center mt-8">
            <nav class="flex items-center space-x-2">
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <button class="px-3 py-1 rounded border border-primary-500 bg-primary-50 text-primary-600">1</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">2</button>
                <button class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">3</button>

                <span class="px-2 text-gray-500">...</span>

                <button class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">8</button>

                <button class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </nav>
        </div>
    </div>

    <!-- نافذة Modal لإضافة مطعم -->
    <div id="addRestaurantModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-xl w-full max-w-md">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold">إضافة مطعم جديد</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <form id="addRestaurantForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">اسم المطعم (عربي)</label>
                        <input type="text" name="ar_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">اسم المطعم (إنجليزي)</label>
                        <input type="text" name="en_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">السعة</label>
                        <input type="number" name="capacity" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">الموقع (عربي)</label>
                        <input type="text" name="ar_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">الموقع (إنجليزي)</label>
                        <input type="text" name="en_location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">صورة المطعم</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center relative">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500">اسحب وأسقط الصورة هنا أو <span class="text-primary-600" id="browseFile">اختر ملف</span></p>
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button class="btn-secondary close-modal">إلغاء</button>
                <button class="btn-primary" id="submitRestaurant">حفظ المطعم</button>
            </div>
        </div>
    </div>

    <!-- نافذة Modal لإغلاق مطعم -->
    <div id="closeRestaurantModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-xl w-full max-w-md">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold">إغلاق المطعم</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <form id="closeRestaurantForm">
                    <input type="hidden" id="close_restaurant_id" name="restaurant_id">

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">الإغلاق من</label>
                        <input type="datetime-local" name="closed_from" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">الإغلاق حتى</label>
                        <input type="datetime-local" name="closed_until" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                </form>
            </div>

            <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button class="btn-secondary close-modal">إلغاء</button>
                <button class="btn-warning" id="submitCloseRestaurant">تأكيد الإغلاق</button>
            </div>
        </div>
    </div>

    <!-- نافذة Modal للحجوزات -->
    <div id="reservationsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
        <div class="bg-white rounded-xl w-full max-w-2xl">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold">حجوزات المطعم</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 max-h-96 overflow-y-auto">
                <input type="hidden" id="reservations_restaurant_id">
                <div id="reservationsList" class="space-y-4">
                    <!-- سيتم ملء الحجوزات هنا -->
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button class="btn-secondary close-modal">إغلاق</button>
            </div>
        </div>
    </div>

    <script>
        // بيانات وهمية للمطاعم (في التطبيق الحقيقي سيتم جلبها من قاعدة البيانات)
        const restaurantsData = [
            {
                id: 1,
                ar_title: "مطعم الشرق الأوسط",
                en_title: "Middle East Restaurant",
                image: "https://via.placeholder.com/300",
                capacity: 50,
                current_reservations: 45,
                ar_location: "الرياض، حي الملك فهد",
                en_location: "Riyadh, King Fahd District",
                is_closed: false,
                closed_from: null,
                closed_until: null
            },
            {
                id: 2,
                ar_title: "مطعم البحر الأحمر",
                en_title: "Red Sea Restaurant",
                image: "https://via.placeholder.com/300",
                capacity: 30,
                current_reservations: 28,
                ar_location: "جدة، حي الصفا",
                en_location: "Jeddah, Al Safa District",
                is_closed: true,
                closed_from: "2023-10-15",
                closed_until: "2023-10-20"
            },
            {
                id: 3,
                ar_title: "مطعم النخيل",
                en_title: "Palm Restaurant",
                image: "https://via.placeholder.com/300",
                capacity: 40,
                current_reservations: 15,
                ar_location: "الدمام، حي الشاطئ",
                en_location: "Dammam, Beach District",
                is_closed: false,
                closed_from: null,
                closed_until: null
            },
            {
                id: 4,
                ar_title: "مطعم القصر الملكي",
                en_title: "Royal Palace Restaurant",
                image: "https://via.placeholder.com/300",
                capacity: 100,
                current_reservations: 95,
                ar_location: "الرياض، حي العليا",
                en_location: "Riyadh, Al Olaya District",
                is_closed: false,
                closed_from: null,
                closed_until: null
            }
        ];

        // دالة لعرض المطاعم
        function renderRestaurants() {
            const restaurantsGrid = document.getElementById('restaurantsGrid');
            restaurantsGrid.innerHTML = '';

            restaurantsData.forEach(restaurant => {
                const statusClass = restaurant.is_closed ? 'closed' :
                                  (restaurant.current_reservations >= restaurant.capacity * 0.8 ? 'low-capacity' : 'open');

                const statusText = restaurant.is_closed ? 'مغلق' :
                                  (restaurant.current_reservations >= restaurant.capacity * 0.8 ? 'شبه ممتلئ' : 'مفتوح');

                const restaurantCard = document.createElement('div');
                restaurantCard.className = 'restaurant-card card';
                restaurantCard.innerHTML = `
                    <div class="relative">
                        <img src="${restaurant.image}" class="w-full h-48 object-cover rounded-lg mb-4" alt="Restaurant Image">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>

                    <h3 class="font-bold text-lg mb-1">${restaurant.ar_title}</h3>
                    <p class="text-gray-500 text-sm mb-3">${restaurant.ar_location}</p>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-700">السعة: ${restaurant.capacity}</span>
                        <span class="text-sm ${restaurant.current_reservations >= restaurant.capacity * 0.8 ? 'text-amber-600' : 'text-gray-500'}">
                            الحجوزات: ${restaurant.current_reservations}
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                        <div class="bg-primary-600 h-2.5 rounded-full"
                             style="width: ${(restaurant.current_reservations / restaurant.capacity) * 100}%"></div>
                    </div>

                    <div class="flex space-x-2">
                        <button class="btn-secondary flex-1 flex items-center justify-center view-reservations" data-id="${restaurant.id}">
                            <i class="fas fa-calendar-alt ml-1"></i>
                            الحجوزات
                        </button>
                        ${restaurant.is_closed ?
                        `<button class="btn-warning px-3 open-restaurant" data-id="${restaurant.id}">
                            <i class="fas fa-lock-open"></i>
                        </button>` :
                        `<button class="btn-warning px-3 close-restaurant" data-id="${restaurant.id}">
                            <i class="fas fa-lock"></i>
                        </button>`}
                        <button class="btn-danger px-3 delete-restaurant" data-id="${restaurant.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;

                restaurantsGrid.appendChild(restaurantCard);
            });

            // إضافة event listeners للأزرار
            document.querySelectorAll('.view-reservations').forEach(btn => {
                btn.addEventListener('click', () => {
                    const restaurantId = btn.getAttribute('data-id');
                    viewReservations(restaurantId);
                });
            });

            document.querySelectorAll('.close-restaurant').forEach(btn => {
                btn.addEventListener('click', () => {
                    const restaurantId = btn.getAttribute('data-id');
                    showCloseRestaurantModal(restaurantId);
                });
            });

            document.querySelectorAll('.open-restaurant').forEach(btn => {
                btn.addEventListener('click', () => {
                    const restaurantId = btn.getAttribute('data-id');
                    openRestaurant(restaurantId);
                });
            });

            document.querySelectorAll('.delete-restaurant').forEach(btn => {
                btn.addEventListener('click', () => {
                    const restaurantId = btn.getAttribute('data-id');
                    deleteRestaurant(restaurantId);
                });
            });
        }

        // دالة لعرض نافذة إضافة مطعم
        function showAddRestaurantModal() {
            document.getElementById('addRestaurantModal').style.display = 'flex';
        }

        // دالة لعرض نافذة إغلاق مطعم
        function showCloseRestaurantModal(restaurantId) {
            document.getElementById('close_restaurant_id').value = restaurantId;
            document.getElementById('closeRestaurantModal').style.display = 'flex';
        }

        // دالة لإخفاء جميع النوافذ المنبثقة
        function hideAllModals() {
            document.querySelectorAll('.fixed.inset-0').forEach(modal => {
                modal.style.display = 'none';
            });
        }

        // دالة لعرض حجوزات مطعم
        function viewReservations(restaurantId) {
            document.getElementById('reservations_restaurant_id').value = restaurantId;

            // في التطبيق الحقيقي، سيتم جلب البيانات من الخادم
            const reservationsList = document.getElementById('reservationsList');
            reservationsList.innerHTML = `
                <div class="text-center py-4">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-primary-600"></div>
                    <p class="mt-2 text-gray-500">جاري تحميل الحجوزات...</p>
                </div>
            `;

            document.getElementById('reservationsModal').style.display = 'flex';

            // محاكاة جلب البيانات من الخادم
            setTimeout(() => {
                const restaurant = restaurantsData.find(r => r.id == restaurantId);
                reservationsList.innerHTML = `
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-bold text-lg mb-2">${restaurant.ar_title}</h4>
                        <p class="text-gray-600">إجمالي الحجوزات: <span class="font-bold">${restaurant.current_reservations}</span> من أصل <span class="font-bold">${restaurant.capacity}</span></p>
                    </div>

                    <div class="border rounded-lg overflow-hidden">
                        <table class="w-full text-right">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3">اسم العميل</th>
                                    <th class="p-3">وقت الحجز</th>
                                    <th class="p-3">عدد الأشخاص</th>
                                    <th class="p-3">الحالة</th>
                                    <th class="p-3">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t">
                                    <td class="p-3">أحمد محمد</td>
                                    <td class="p-3">2023-10-18 19:00</td>
                                    <td class="p-3">4</td>
                                    <td class="p-3"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">مؤكد</span></td>
                                    <td class="p-3">
                                        <button class="text-red-600 hover:text-red-800 reject-reservation" data-id="1">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-t">
                                    <td class="p-3">فاطمة عبدالله</td>
                                    <td class="p-3">2023-10-18 20:30</td>
                                    <td class="p-3">2</td>
                                    <td class="p-3"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">في الانتظار</span></td>
                                    <td class="p-3">
                                        <button class="text-red-600 hover:text-red-800 reject-reservation" data-id="2">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `;

                // إضافة event listeners لأزرار رفض الحجوزات
                document.querySelectorAll('.reject-reservation').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const reservationId = btn.getAttribute('data-id');
                        rejectReservation(reservationId);
                    });
                });
            }, 1000);
        }

        // دالة لإضافة مطعم
        function addRestaurant(formData) {
            // في التطبيق الحقيقي، سيتم إرسال البيانات إلى الخادم
            console.log('إضافة مطعم جديد:', formData);

            // محاكاة الإضافة
            const newRestaurant = {
                id: restaurantsData.length + 1,
                ar_title: formData.get('ar_title'),
                en_title: formData.get('en_title'),
                image: URL.createObjectURL(formData.get('image')),
                capacity: parseInt(formData.get('capacity')),
                current_reservations: 0,
                ar_location: formData.get('ar_location'),
                en_location: formData.get('en_location'),
                is_closed: false,
                closed_from: null,
                closed_until: null
            };

            restaurantsData.push(newRestaurant);
            renderRestaurants();
            updateStatistics();

            // إظهار رسالة نجاح
            alert('تم إضافة المطعم بنجاح!');
        }

        // دالة لحذف مطعم
        function deleteRestaurant(restaurantId) {
            if (confirm('هل أنت متأكد من أنك تريد حذف هذا المطعم؟')) {
                // في التطبيق الحقيقي، سيتم إرسال طلب الحذف إلى الخادم
                console.log('حذف مطعم:', restaurantId);

                // محاكاة الحذف
                const index = restaurantsData.findIndex(r => r.id == restaurantId);
                if (index !== -1) {
                    restaurantsData.splice(index, 1);
                    renderRestaurants();
                    updateStatistics();

                    // إظهار رسالة نجاح
                    alert('تم حذف المطعم بنجاح!');
                }
            }
        }

        // دالة لإغلاق مطعم
        function closeRestaurant(restaurantId, closedFrom, closedUntil) {
            // في التطبيق الحقيقي، سيتم إرسال البيانات إلى الخادم
            console.log('إغلاق مطعم:', restaurantId, closedFrom, closedUntil);

            // محاكاة الإغلاق
            const restaurant = restaurantsData.find(r => r.id == restaurantId);
            if (restaurant) {
                restaurant.is_closed = true;
                restaurant.closed_from = closedFrom;
                restaurant.closed_until = closedUntil;
                renderRestaurants();
                updateStatistics();

                // إظهار رسالة نجاح
                alert('تم إغلاق المطعم بنجاح!');
            }
        }

        // دالة لفتح مطعم
        function openRestaurant(restaurantId) {
            if (confirm('هل أنت متأكد من أنك تريد فتح هذا المطعم؟')) {
                // في التطبيق الحقيقي، سيتم إرسال الطلب إلى الخادم
                console.log('فتح مطعم:', restaurantId);

                // محاكاة الفتح
                const restaurant = restaurantsData.find(r => r.id == restaurantId);
                if (restaurant) {
                    restaurant.is_closed = false;
                    restaurant.closed_from = null;
                    restaurant.closed_until = null;
                    renderRestaurants();
                    updateStatistics();

                    // إظهار رسالة نجاح
                    alert('تم فتح المطعم بنجاح!');
                }
            }
        }

        // دالة لرفض حجز
        function rejectReservation(reservationId) {
            if (confirm('هل أنت متأكد من أنك تريد رفض هذا الحجز؟')) {
                // في التطبيق الحقيقي، سيتم إرسال الطلب إلى الخادم
                console.log('رفض حجز:', reservationId);

                // إظهار رسالة نجاح
                alert('تم رفض الحجز بنجاح!');

                // إعادة تحميل قائمة الحجوزات
                viewReservations(document.getElementById('reservations_restaurant_id').value);
            }
        }

        // دالة لتحديث الإحصائيات
        function updateStatistics() {
            const total = restaurantsData.length;
            const active = restaurantsData.filter(r => !r.is_closed).length;
            const closed = restaurantsData.filter(r => r.is_closed).length;
            const todayReservations = restaurantsData.reduce((sum, r) => sum + r.current_reservations, 0);

            document.getElementById('totalRestaurants').textContent = total;
            document.getElementById('activeRestaurants').textContent = active;
            document.getElementById('closedRestaurants').textContent = closed;
            document.getElementById('todayReservations').textContent = todayReservations;
        }

        // تهيئة الصفحة عند التحميل
        document.addEventListener('DOMContentLoaded', function() {
            // عرض المطاعم
            renderRestaurants();
            updateStatistics();

            // زر إضافة مطعم
            document.getElementById('addRestaurantBtn').addEventListener('click', showAddRestaurantModal);

            // زر حفظ مطعم
            document.getElementById('submitRestaurant').addEventListener('click', () => {
                const form = document.getElementById('addRestaurantForm');
                const formData = new FormData(form);

                // التحقق من صحة البيانات
                if (!formData.get('ar_title') || !formData.get('en_title') || !formData.get('capacity') ||
                    !formData.get('ar_location') || !formData.get('en_location') || !formData.get('image')) {
                    alert('يرجى ملء جميع الحقول المطلوبة');
                    return;
                }

                addRestaurant(formData);
                hideAllModals();
                form.reset();
            });

            // زر تأكيد إغلاق مطعم
            document.getElementById('submitCloseRestaurant').addEventListener('click', () => {
                const form = document.getElementById('closeRestaurantForm');
                const formData = new FormData(form);

                const restaurantId = formData.get('restaurant_id');
                const closedFrom = formData.get('closed_from');
                const closedUntil = formData.get('closed_until');

                if (!closedFrom || !closedUntil) {
                    alert('يرجى تحديد تاريخي البدء والانتهاء للإغلاق');
                    return;
                }

                closeRestaurant(restaurantId, closedFrom, closedUntil);
                hideAllModals();
                form.reset();
            });

            // أزرار إغلاق النوافذ
            document.querySelectorAll('.close-modal').forEach(btn => {
                btn.addEventListener('click', hideAllModals);
            });

            // إغلاق النوافذ عند النقر خارج المحتوى
            document.querySelectorAll('.fixed.inset-0').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideAllModals();
                    }
                });
            });

            // تمكين اختيار الملف عند النقر على "اختر ملف"
            document.getElementById('browseFile').addEventListener('click', () => {
                document.querySelector('input[name="image"]').click();
            });
        });
    </script>
</body>
</html>
