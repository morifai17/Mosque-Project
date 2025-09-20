<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة إدارة المنتجات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f9f9f9; }
        .product-card { border-radius:12px; box-shadow:0 3px 8px rgba(0,0,0,.1); }
        .product-image { height:180px; object-fit:cover; border-radius:12px 12px 0 0; }
    </style>
</head>
<body class="container py-4">

<h2 class="text-center mb-4">📦 إدارة المنتجات</h2>

<div class="text-end mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">➕ إضافة منتج</button>
</div>

<div class="row" id="products-container">
    <div class="text-center">⏳ جاري تحميل المنتجات...</div>
</div>

<!-- Modal إضافة منتج -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="createForm" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header"><h5 class="modal-title">➕ إضافة منتج جديد</h5></div>
            <div class="modal-body">
                <input class="form-control mb-2" name="title" placeholder="اسم المنتج" required>
                <input class="form-control mb-2" name="price" placeholder="السعر" type="number" required>
                <input class="form-control mb-2" name="quantity" placeholder="الكمية" type="number" required>
                <textarea class="form-control mb-2" name="description" placeholder="الوصف"></textarea>
                <select class="form-control mb-2" name="category_id" required>
                    <option value="">اختر الفئة</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                <input class="form-control mb-2" name="image" type="file">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal تعديل منتج -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header"><h5 class="modal-title">✏️ تعديل المنتج</h5></div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit-id">
                <input class="form-control mb-2" name="title" id="edit-title" placeholder="اسم المنتج" required>
                <input class="form-control mb-2" name="price" id="edit-price" type="number" required>
                <input class="form-control mb-2" name="quantity" id="edit-quantity" type="number" required>
                <textarea class="form-control mb-2" name="description" id="edit-description"></textarea>
                <select class="form-control mb-2" name="category_id" id="edit-category_id" required>
                    <option value="">اختر الفئة</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                <input class="form-control mb-2" name="image" type="file">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button class="btn btn-primary" type="submit">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
async function loadProducts() {
    const container = document.getElementById("products-container");
    container.innerHTML = "<div class='text-center'>⏳ جاري التحميل...</div>";
    try {
        const response = await fetch("{{ url('dashboard/products/index') }}");
        const data = await response.json();
        container.innerHTML = "";

        if (data.success && data.products.length) {
            data.products.forEach(p => {
                container.innerHTML += `
                <div class="col-md-4 mb-3">
                    <div class="card product-card">
                        <img src="/storage/${p.image || 'default-image.png'}" class="product-image" alt="${p.title}">
                        <div class="card-body">
                            <h5>${p.title}</h5>
                            <p class="text-muted">الفئة: ${p.category}</p>
                            <p>💲 السعر: ${p.price} | 📦 ${p.quantity}</p>
                            <p>${p.description || ''}</p>
                            <button class="btn btn-sm btn-primary" onclick="openEdit(${JSON.stringify(p).replace(/"/g,'&quot;')})">✏️ تعديل</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">🗑 حذف</button>
                        </div>
                    </div>
                </div>`;
            });
        } else {
            container.innerHTML = "<div class='text-center text-danger'>❌ لا توجد منتجات</div>";
        }
    } catch (err) {
        container.innerHTML = "<div class='text-center text-danger'>⚠️ فشل تحميل المنتجات</div>";
        console.error(err);
    }
}

// إضافة منتج
document.getElementById("createForm").addEventListener("submit", async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
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
    }
});

// فتح تعديل
function openEdit(product) {
    document.getElementById("edit-id").value = product.id;
    document.getElementById("edit-title").value = product.title;
    document.getElementById("edit-price").value = product.price;
    document.getElementById("edit-quantity").value = product.quantity;
    document.getElementById("edit-description").value = product.description;
    document.getElementById("edit-category_id").value = product.category_id;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// تعديل منتج
document.getElementById("editForm").addEventListener("submit", async e => {
    e.preventDefault();
    const id = document.getElementById("edit-id").value;
    const formData = new FormData(e.target);
    formData.append('_method', 'PUT'); // Laravel يفهم أنها تعديل
    try {
        const response = await fetch("{{ url('dashboard/products/update') }}/" + id, {
            method:"POST",
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

// حذف منتج
async function deleteProduct(id) {
    if (!confirm("هل أنت متأكد من الحذف؟")) return;

    try {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'DELETE');

      // للـ Dashboard العادي
fetch("/dashboard/products/destroy/" + id, {
    method: "DELETE",
    headers: {
        "X-CSRF-TOKEN": '{{ csrf_token() }}',
        "Accept": "application/json"
    }
});


        const data = await response.json();

        if (data.success) {
            alert("✅ تم حذف المنتج بنجاح!");
            loadProducts();
        } else {
            alert("❌ فشل الحذف: " + (data.message || 'خطأ غير معروف'));
        }
    } catch (err) {
        alert("⚠️ حدث خطأ أثناء الحذف");
        console.error(err);
    }
}

// تحميل المنتجات عند فتح الصفحة
loadProducts();
</script>
</body>
</html>
