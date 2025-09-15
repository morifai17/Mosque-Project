<div class="space-y-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white gradient-text">الإعدادات</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">إدارة إعدادات حسابك وتفضيلاتك</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 max-w-2xl mx-auto">
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-3">المعلومات الشخصية</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الاسم الأول</label>
                        <input type="text" value="محمد" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الاسم الأخير</label>
                        <input type="text" value="أحمد" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-800 dark:text-white transition">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-3">التفضيلات</h3>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-700 dark:text-gray-300">وضع الظلام</span>
                    <button x-data="{ dark: false }" @click="dark = !dark; $dispatch('toggle-dark')" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-gray-700 transition">
                        <span class="inline-block h-4 w-4 transform bg-white rounded-full transition translate-x-1" :class="{ 'translate-x-6': dark }"></span>
                    </button>
                </div>
            </div>

            <div class="pt-4 border-t dark:border-gray-700">
                <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    حفظ التغييرات
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function initSettingsSection() {
    // توابع قسم الإعدادات
    console.log("تم تحميل قسم الإعدادات");
}
</script>
