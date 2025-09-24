<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إدارة الكوبونات - لوحة التحكم</title>
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

        .coupon-card {
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .coupon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
        }

        .badge-active { background-color: #28a745; }
        .badge-inactive { background-color: #dc3545; }
        .badge-expired { background-color: #6c757d; }

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

        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
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
            <div class="nav-item">
                <a href="{{ route('dashboard.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>المشرفين</span>
                </a>
            </div>

            <div class="nav-item has-submenu" onclick="toggleSubmenu(this)">
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

            <div class="nav-item">
                <a href="{{ route('dashboard.products') }}">
                    <i class="fas fa-box-open"></i>
                    <span>المنتجات</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.categories') }}">
                    <i class="fas fa-tags"></i>
                    <span>الفئات</span>
                </a>
            </div>

            <div class="nav-item active-nav">
                <a href="{{ route('dashboard.coupons') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>الكوبونات</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.offers') }}">
                    <i class="fas fa-percentage"></i>
                    <span>العروض</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('dashboard.order') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>الطلبات</span>
                </a>
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
            <h1 class="page-title text-2xl font-bold text-gray-800">🎫 إدارة الكوبونات</h1>

            <div class="flex justify-between items-center mb-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md flex-1 mr-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                        </div>
                        <div class="mr-3">
                            <p class="text-sm text-blue-700">
                                يمكنك إدارة الكوبونات من خلال هذه الصفحة. إضافة، تعديل أو حذف الكوبونات.
                            </p>
                        </div>
                    </div>
                </div>

                <button class="btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                    <i class="fas fa-plus ml-2"></i> إضافة كوبون
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="couponsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th>العنوان</th>
                            <th>نسبة الخصم</th>
                            <th>الحد الأقصى</th>
                            <th>المستخدم</th>
                            <th>أدنى نقاط</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="coupons-container">
                        <tr>
                            <td colspan="11" class="text-center py-8">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                                <p class="mt-4 text-gray-600">جاري تحميل الكوبونات...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal إضافة كوبون -->
    <div class="modal fade" id="createCouponModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="createCouponForm" class="modal-content">
                @csrf
                <div class="modal-header bg-blue-500 text-white">
                    <h5 class="modal-title">➕ إضافة كوبون جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الكود</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نسبة الخصم (%)</label>
                        <input type="number" name="discount_percentage" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الحد الأقصى للاستخدام</label>
                        <input type="number" name="usage_limit" class="form-control" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">أدنى نقاط</label>
                        <input type="number" name="min_points" class="form-control" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="starts_at" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" class="form-control">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" checked>
                        <label class="form-check-label">نشط</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal تعديل كوبون -->
    <div class="modal fade" id="editCouponModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editCouponForm" class="modal-content">
                @csrf
                <div class="modal-header bg-blue-500 text-white">
                    <h5 class="modal-title">✏️ تعديل الكوبون</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">الكود</label>
                        <input type="text" name="code" id="edit-code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="title" id="edit-title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نسبة الخصم (%)</label>
                        <input type="number" name="discount_percentage" id="edit-discount_percentage" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الحد الأقصى للاستخدام</label>
                        <input type="number" name="usage_limit" id="edit-usage_limit" class="form-control" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">أدنى نقاط</label>
                        <input type="number" name="min_points" id="edit-min_points" class="form-control" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="starts_at" id="edit-starts_at" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" id="edit-expires_at" class="form-control">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" id="edit-is_active" class="form-check-input">
                        <label class="form-check-label">نشط</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function loadCoupons() {
        const container = document.getElementById("coupons-container");
        container.innerHTML = `
            <tr>
                <td colspan="11" class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-4 text-gray-600">جاري تحميل الكوبونات...</p>
                </td>
            </tr>
        `;

        try {
            const response = await fetch('/dashboard/coupons/index');
            const data = await response.json();
            container.innerHTML = '';

            if (data.success && data.coupons && data.coupons.length) {
                data.coupons.forEach(c => {
                    const starts = c.starts_at ? new Date(c.starts_at).toLocaleDateString('ar-EG') : '-';
                    const expires = c.expires_at ? new Date(c.expires_at).toLocaleDateString('ar-EG') : '-';
                    const isExpired = c.expires_at && new Date(c.expires_at) < new Date();
                    const statusClass = isExpired ? 'badge-expired' : (c.is_active ? 'badge-active' : 'badge-inactive');
                    const statusText = isExpired ? 'منتهي' : (c.is_active ? 'نشط' : 'غير نشط');

                    container.innerHTML += `
                        <tr class="coupon-card">
                            <td>${c.id}</td>
                            <td><strong>${c.code}</strong></td>
                            <td>${c.title}</td>
                            <td><span class="badge bg-success">${c.discount_percentage}%</span></td>
                            <td>${c.usage_limit ?? '∞'}</td>
                            <td><span class="badge bg-info">${c.used_count ?? 0}</span></td>
                            <td>${c.min_points ?? '-'}</td>
                            <td>${starts}</td>
                            <td>${expires}</td>
                            <td><span class="badge ${statusClass}">${statusText}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" onclick="editCoupon(${c.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCoupon(${c.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                container.innerHTML = `
                    <tr>
                        <td colspan="11" class="text-center py-8">
                            <i class="fas fa-ticket-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">لا توجد كوبونات</p>
                            <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                                <i class="fas fa-plus ml-2"></i> إضافة كوبون جديد
                            </button>
                        </td>
                    </tr>
                `;
            }
        } catch (err) {
            container.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                        <p class="text-red-600">فشل تحميل الكوبونات</p>
                        <button class="btn bg-blue-500 hover:bg-blue-600 text-white mt-4" onclick="loadCoupons()">
                            <i class="fas fa-refresh ml-2"></i> إعادة المحاولة
                        </button>
                    </td>
                </tr>
            `;
            console.error('Error loading coupons:', err);
        }
    }

    // إضافة كوبون
    document.getElementById('createCouponForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.is_active = formData.get('is_active') ? true : false;

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        try {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';
            submitBtn.disabled = true;

            const response = await fetch('/dashboard/coupons/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            alert(result.message);
            if(result.success){
                loadCoupons();
                bootstrap.Modal.getInstance(document.getElementById('createCouponModal')).hide();
                this.reset();
            }
        } catch(err) {
            alert('⚠️ حدث خطأ أثناء الإضافة');
            console.error('Error creating coupon:', err);
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // تعديل كوبون
    async function editCoupon(id){
        try {
            const response = await fetch(`/dashboard/coupons/${id}`);
            const result = await response.json();

            if(result.success){
                const coupon = result.coupon;
                document.getElementById('edit-id').value = coupon.id;
                document.getElementById('edit-code').value = coupon.code;
                document.getElementById('edit-title').value = coupon.title;
                document.getElementById('edit-discount_percentage').value = coupon.discount_percentage;
                document.getElementById('edit-usage_limit').value = coupon.usage_limit || '';
                document.getElementById('edit-min_points').value = coupon.min_points || '';
                document.getElementById('edit-starts_at').value = coupon.starts_at || '';
                document.getElementById('edit-expires_at').value = coupon.expires_at || '';
                document.getElementById('edit-is_active').checked = coupon.is_active;

                new bootstrap.Modal(document.getElementById('editCouponModal')).show();
            }
        } catch(err) {
            alert('⚠️ حدث خطأ أثناء تحميل البيانات');
            console.error('Error loading coupon:', err);
        }
    }

    // إرسال تعديل كوبون
    document.getElementById('editCouponForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.is_active = formData.get('is_active') ? true : false;

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        try {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جاري الحفظ...';
            submitBtn.disabled = true;

            const response = await fetch(`/dashboard/coupons/update/${data.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            alert(result.message);
            if(result.success){
                loadCoupons();
                bootstrap.Modal.getInstance(document.getElementById('editCouponModal')).hide();
            }
        } catch(err) {
            alert('⚠️ حدث خطأ أثناء التعديل');
            console.error('Error updating coupon:', err);
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // حذف كوبون
    async function deleteCoupon(id){
        if(!confirm('هل أنت متأكد من حذف هذا الكوبون؟')) return;

        try {
            const response = await fetch(`/dashboard/coupons/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            alert(result.message);
            if(result.success) loadCoupons();
        } catch(err) {
            alert('⚠️ حدث خطأ أثناء الحذف');
            console.error('Error deleting coupon:', err);
        }
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

    // تحميل الكوبونات عند فتح الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        loadCoupons();
    });
    </script>
</body>
</html>
