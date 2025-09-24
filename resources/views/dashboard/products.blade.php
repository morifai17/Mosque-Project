<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات - لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(to bottom, #4f46e5, #7c3aed);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transform: translateX(0);
            transition: transform 0.4s ease;
        }

        .sidebar:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }

        .nav-item {
            position: relative;
            border-radius: 0.5rem;
            margin: 0.5rem 1rem;
            overflow: hidden;
        }

        .nav-item:before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
            border-radius: 0.5rem;
        }

        .nav-item:hover:before {
            width: 100%;
        }

        .nav-item a {
            position: relative;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
        }

        .nav-item i {
            margin-left: 0.75rem;
            font-size: 1.2rem;
        }

        .nav-item:hover {
            transform: translateX(-5px);
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 1.5rem 1rem;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo i {
            margin-left: 0.75rem;
            font-size: 1.8rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .content-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            border-radius: 2px;
        }

        .product-card {
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
        }

        .product-image {
            height: 180px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        /* تأثيرات للهاتف */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 100;
                height: 100%;
            }

            .sidebar-open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 101;
                background: #4f46e5;
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
        }

        /* تأثيرات التحميل للعناصر */
        .delayed-1 { animation-delay: 0.1s; }
        .delayed-2 { animation-delay: 0.2s; }
        .delayed-3 { animation-delay: 0.3s; }
        .delayed-4 { animation-delay: 0.4s; }
        .delayed-5 { animation-delay: 0.5s; }
        .delayed-6 { animation-delay: 0.6s; }
        .delayed-7 { animation-delay: 0.7s; }
        .delayed-8 { animation-delay: 0.8s; }
        .delayed-9 { animation-delay: 0.9s; }
        .delayed-10 { animation-delay: 1.0s; }
        .delayed-11 { animation-delay: 1.1s; }

        /* تأثيرات النص */
        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .active-nav {
            background: rgba(255, 255, 255, 0.2);
        }

        .active-nav:before {
            width: 100%;
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.open {
            max-height: 500px;
        }

        .has-submenu::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .has-submenu.open::after {
            transform: rotate(180deg);
        }

        /* تعديلات البوتستراب لتتناسب مع التصميم */
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- زر القائمة للهاتف -->
    <button class="menu-toggle md:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- سايدبار -->
    <aside class="sidebar w-64 min-h-screen">
        <div class="logo">
            <i class="fas fa-mosque"></i>
            <h1 class="text-xl font-bold">مسجد الرحمن</h1>
        </div>
        <nav class="mt-6">
            <div class="nav-item delayed-1">
                <a href="{{ route('dashboard.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المشرفين</span>
                </a>
            </div>

            <div class="nav-item delayed-2 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-users"></i>
                    <span>المستخدمين</span>
                </a>
                <div class="submenu pl-4">
                    <div class="nav-item">
                        <a href="{{ route('dashboard.users') }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>الطلاب</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('dashboard.teacher') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المعلمين</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nav-item delayed-3 active-nav">
                <a href="{{ route('dashboard.products') }}">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
            </div>

            <div class="nav-item delayed-4">
                <a href="{{ route('dashboard.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>الفئات</span>
                </a>
            </div>

            <div class="nav-item delayed-5">
                <a href="{{ route('dashboard.coupons') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>الكوبونات</span>
                </a>
            </div>

            <div class="nav-item delayed-6">
                <a href="{{ route('dashboard.offers') }}">
                    <i class="fas fa-percentage"></i>
                    <span>العروض</span>
                </a>
            </div>

            <div class="nav-item delayed-7">
                <a href="{{ route('dashboard.order') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
            </div>

            {{-- <div class="nav-item delayed-8">
                <a href="{{ route('dashboard.QuranCycle') }}">
                    <i class="fas fa-book-quran"></i>
                    <span>دورات القرآن</span>
                </a>
            </div> --}}

            <div class="nav-item delayed-9 has-submenu" onclick="toggleSubmenu(this)">
                <a href="javascript:void(0)">
                    <i class="fas fa-graduation-cap"></i>
                    <span>المحتوى التعليمي</span>
                </a>
                {{-- <div class="submenu pl-4">
                    <div class="nav-item">
                        <a href="{{ route('dashboard.students-content') }}">
                            <i class="fas fa-book-reader"></i>
                            <span>محتويات الطلاب</span>
                        </a>
                    </div> --}}
                </div>
            </div>
        </nav>

        <!-- معلومات المستخدم -->
        <div class="absolute bottom-0 w-full p-4 text-white border-t border-white/10">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div class="mr-3">
                    <p class="font-medium">اسم المستخدم</p>
                    <p class="text-sm text-white/70">مدير النظام</p>
                </div>
                <a href="#" class="text-white/70 hover:text-white ml-auto">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="flex-1 p-6">
        <div class="content-card p-6">
            <h1 class="page-title text-2xl font-bold text-gray-800">📦 إدارة المنتجات</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md flex-1 mr-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                        </div>
                        <div class="mr-3">
                            <p class="text-sm text-blue-700">
                                يمكنك إدارة المنتجات من خلال هذه الصفحة. إضافة، تعديل أو حذف المنتجات.
                            </p>
                        </div>
                    </div>
                </div>

                <button class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus ml-2"></i> إضافة منتج
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="products-container">
                <div class="col-span-full text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-4 text-gray-600">جاري تحميل المنتجات...</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal إضافة منتج -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="createForm" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-blue-500 text-white">
                    <h5 class="modal-title">➕ إضافة منتج جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">اسم المنتج</label>
                        <input class="form-control" name="title" placeholder="اسم المنتج" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر</label>
                        <input class="form-control" name="price" placeholder="السعر" type="number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الكمية</label>
                        <input class="form-control" name="quantity" placeholder="الكمية" type="number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" placeholder="الوصف" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الفئة</label>
                        <select class="form-control" name="category_id" required>
                            <option value="">اختر الفئة</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">صورة المنتج</label>
                        <input class="form-control" name="image" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal تعديل منتج -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editForm" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-blue-500 text-white">
                    <h5 class="modal-title">✏️ تعديل المنتج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">اسم المنتج</label>
                        <input class="form-control" name="title" id="edit-title" placeholder="اسم المنتج" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">السعر</label>
                        <input class="form-control" name="price" id="edit-price" type="number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الكمية</label>
                        <input class="form-control" name="quantity" id="edit-quantity" type="number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" id="edit-description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الفئة</label>
                        <select class="form-control" name="category_id" id="edit-category_id" required>
                            <option value="">اختر الفئة</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">صورة المنتج</label>
                        <input class="form-control" name="image" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    async function loadProducts() {
        const container = document.getElementById("products-container");
        container.innerHTML = `
            <div class="col-span-full text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                <p class="mt-4 text-gray-600">جاري تحميل المنتجات...</p>
            </div>
        `;

        try {
            const response = await fetch("{{ url('dashboard/products/index') }}");
            const data = await response.json();
            container.innerHTML = "";

            if (data.success && data.products.length) {
                data.products.forEach(p => {
const imageUrl = p.image ? `/storage/products/${p.image}` : '/images/default-image.png';
                    container.innerHTML += `
                    <div class="bg-white rounded-xl overflow-hidden shadow-md product-card">
                        <img src="${imageUrl}" class="w-full h-48 object-cover" alt="${p.title}">
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 text-gray-800">${p.title}</h3>
                            <p class="text-sm text-gray-600 mb-2">الفئة: ${p.category}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-green-600 font-bold">${p.price} 💲</span>
                                <span class="text-blue-600">${p.quantity} 📦</span>
                            </div>
                            <p class="text-gray-700 text-sm mb-4">${p.description || ''}</p>
                            <div class="flex justify-between">
                                <button class="btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg edit-btn flex items-center text-sm"
                                        data-id="${p.id}"
                                        data-title="${p.title}"
                                        data-price="${p.price}"
                                        data-quantity="${p.quantity}"
                                        data-description="${p.description || ''}"
                                        data-category="${p.category_id}">
                                    <i class="fas fa-edit ml-1"></i> تعديل
                                </button>
                                <button class="btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg delete-btn flex items-center text-sm" data-id="${p.id}">
                                    <i class="fas fa-trash ml-1"></i> حذف
                                </button>
                            </div>
                        </div>
                    </div>`;
                });

                // تفعيل أزرار التعديل والحذف بعد إنشاء العناصر
                attachEditButtons();
                attachDeleteButtons();

            } else {
                container.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">لا توجد منتجات</p>
                        <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus ml-2"></i> إضافة منتج جديد
                        </button>
                    </div>`;
            }
        } catch (err) {
            container.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                    <p class="text-red-600">فشل تحميل المنتجات</p>
                    <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" onclick="loadProducts()">
                        <i class="fas fa-refresh ml-2"></i> إعادة المحاولة
                    </button>
                </div>`;
            console.error(err);
        }
    }

    // إضافة منتج
    document.getElementById("createForm").addEventListener("submit", async e => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        try {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';
            submitBtn.disabled = true;

            const response = await fetch("{{ url('dashboard/products/store') }}", {
                method: "POST",
                body: formData
            });
            const data = await response.json();
            if(data.success) {
                alert("✅ تم إضافة المنتج بنجاح!");
                e.target.reset();
                bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
                loadProducts();
            } else {
                alert("❌ فشل الإضافة: " + (data.message || 'خطأ غير معروف'));
            }
        } catch(err) {
            alert("⚠️ حدث خطأ أثناء الإضافة");
            console.error(err);
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // تعديل منتج
   // تعديل منتج
document.getElementById("editForm").addEventListener("submit", async e => {
    e.preventDefault();
    const id = document.getElementById("edit-id").value;
    const formData = new FormData(e.target);
    formData.append('_method', 'PUT');

    try {
        const response = await fetch("{{ url('dashboard/products') }}/" + id, {
            method: "POST", // Laravel سيعامله كـ PUT
            body: formData
        });
        const data = await response.json();
        if(data.success) {
            alert("✅ تم تعديل المنتج بنجاح!");
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            loadProducts();
        } else {
            alert("❌ فشل التعديل: " + (data.message || 'خطأ غير معروف'));
        }
    } catch(err) {
        alert("⚠️ حدث خطأ أثناء التعديل");
        console.error(err);
    }
});


    // ربط أزرار التعديل
    function attachEditButtons() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('edit-id').value = btn.dataset.id;
                document.getElementById('edit-title').value = btn.dataset.title;
                document.getElementById('edit-price').value = btn.dataset.price;
                document.getElementById('edit-quantity').value = btn.dataset.quantity;
                document.getElementById('edit-description').value = btn.dataset.description;
                document.getElementById('edit-category_id').value = btn.dataset.category;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });
    }

    // ربط أزرار الحذف
    async function attachDeleteButtons() {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            if(confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
                let formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const response = await fetch("{{ url('dashboard/products') }}/" + id, {
                        method: 'POST', // Laravel يتعامل معها كـ DELETE
                        body: formData
                    });
                    const data = await response.json();
                    if(data.success) {
                        alert("✅ تم حذف المنتج بنجاح!");
                        loadProducts();
                    } else {
                        alert("❌ فشل الحذف: " + (data.message || 'خطأ غير معروف'));
                    }
                } catch(err) {
                    alert("⚠️ حدث خطأ أثناء الحذف");
                    console.error(err);
                }
            }
        });
    });
}

    // دالة لإظهار/إخفاء القائمة الجانبية في الهاتف
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('sidebar-open');
    }

    // دالة لإظهار/إخفاء القوائم الفرعية
    function toggleSubmenu(element) {
        element.classList.toggle('open');
        const submenu = element.querySelector('.submenu');
        submenu.classList.toggle('open');
    }

    // تحميل المنتجات عند فتح الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        loadProducts();

        // تعطيل الانتقال إلى الروابط في القوائم التي تحتوي على قوائم فرعية
        document.querySelectorAll('.has-submenu > a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });
    });
    </script>
</body>
</html>
