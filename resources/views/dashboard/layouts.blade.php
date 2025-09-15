<!-- resources/views/dashboard/layout.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'لوحة التحكم')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- سايدبار -->
    <aside class="w-64 bg-white shadow-md min-h-screen">
        <div class="p-4 font-bold text-xl text-blue-600">لوحة التحكم</div>
        <nav class="mt-6">
            <a href="{{ route('dashboard.admins') }}" class="block p-3 hover:bg-gray-200">المدراء</a>
            <a href="{{ route('dashboard.users') }}" class="block p-3 hover:bg-gray-200">المستخدمين</a>
            <a href="{{ route('dashboard.products') }}" class="block p-3 hover:bg-gray-200">المنتجات</a>
            <a href="{{ route('dashboard.coupons') }}" class="block p-3 hover:bg-gray-200">الكوبونات</a>
        </nav>
    </aside>

    <!-- المحتوى -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">@yield('page-title')</h1>
        @yield('content')
    </main>
</body>
</html>
