<div class="space-y-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white gradient-text">طلباتي</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">تابع حالة طلباتك السابقة</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b dark:border-gray-700">
                        <th class="px-4 py-2 text-right">رقم الطلب</th>
                        <th class="px-4 py-2 text-right">التاريخ</th>
                        <th class="px-4 py-2 text-right">الحالة</th>
                        <th class="px-4 py-2 text-right">المجموع</th>
                        <th class="px-4 py-2 text-right">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3">#1234</td>
                        <td class="px-4 py-3">15/03/2023</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">مكتمل</span></td>
                        <td class="px-4 py-3">₪150</td>
                        <td class="px-4 py-3">
                            <button class="text-primary-600 hover:text-primary-800 dark:text-golden-400 dark:hover:text-golden-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function initMyOrdersSection() {
    // توابع قسم طلباتي
    console.log("تم تحميل قسم طلباتي");
}
</script>
