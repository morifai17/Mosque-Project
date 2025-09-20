<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductDashboardController extends Controller
{
    /**
     * عرض جميع المنتجات
     */
public function index()
{
    $products = Product::with('category')->get();

    $data = $products->map(function($product) {
        return [
            'id' => $product->id,   // ← لازم يكون موجود
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'description' => $product->description,
            'image' => $product->image,
            'category' => $product->category ? $product->title : null,
        ];
    });

    return response()->json(['success' => true, 'products' => $data]);
}

public function page()
{
    $categories = Category::all(); // جلب كل الفئات
    return view('dashboard.products', compact('categories')); // تمرير المتغير للـ Blade
}



    /**
     * إضافة منتج جديد
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // إنشاء المنتج
        $product = Product::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ]);

        // حفظ الصورة إذا وجدت
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');

            // تحديث الصورة الرئيسية في المنتج
            $product->update(['image' => $imagePath]);

            // إضافة الصورة إلى جدول الصور
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_main' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج بنجاح',
            'product' => $product->load(['category', 'images'])
        ], 201);
    }

    /**
     * عرض منتج محدد
     */
    public function show()
{
    $products = Product::with(['category', 'images'])->get();

    if ($products->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'لا توجد منتجات'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'products' => $products,
        'count' => $products->count()
    ]);
}

    /**
     * تحديث منتج موجود
     */
 public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => '❌ المنتج غير موجود'
        ], 404);
    }

    $product->update($request->only([
        'title', 'price', 'quantity', 'description', 'category_id'
    ]));

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
        $product->save();
    }

    return response()->json([
        'success' => true,
        'message' => '✅ تم تعديل المنتج بنجاح',
        'product' => $product
    ]);
}



    /**
     * حذف منتج
     */
 public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود'
        ], 404);
    }

    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return response()->json([
        'success' => true,
        'message' => 'تم حذف المنتج بنجاح'
    ]);
}



    /**
     * إضافة صور إضافية للمنتج
     */
    public function addImages(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'set_as_main' => 'nullable|boolean'
        ]);

        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('products', 'public');

            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_main' => false
            ]);

            $uploadedImages[] = $productImage;
        }

        // إذا طلب تعيين أحد الصور كرئيسية
        if ($request->set_as_main && count($uploadedImages) > 0) {
            $mainImage = $uploadedImages[0];
            $mainImage->update(['is_main' => true]);
            $product->update(['image' => $mainImage->image_path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الصور بنجاح',
            'images' => $uploadedImages
        ]);
    }

    /**
     * تعيين صورة رئيسية
     */
    public function setMainImage(Request $request, $productId, $imageId)
    {
        $product = Product::find($productId);
        $image = ProductImage::find($imageId);

        if (!$product || !$image || $image->product_id != $productId) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج أو الصورة غير موجودة'
            ], 404);
        }

        // إلغاء تعيين جميع الصور كرئيسية
        ProductImage::where('product_id', $productId)->update(['is_main' => false]);

        // تعيين الصورة المحددة كرئيسية
        $image->update(['is_main' => true]);
        $product->update(['image' => $image->image_path]);

        return response()->json([
            'success' => true,
            'message' => 'تم تعيين الصورة كرئيسية بنجاح'
        ]);
    }
}
