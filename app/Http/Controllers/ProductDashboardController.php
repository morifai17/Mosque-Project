<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductDashboardController extends Controller
{
    /**
     * عرض جميع المنتجات مع البحث والترتيب
     */
    public function index(Request $request)
    {
        // التحقق من صلاحية المشرف
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $products = Product::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->orderBy('price', $request->sort_price ?? 'desc')
            ->paginate(10);

        $categories = Category::all();

        return response()->json([
            'success' => true,
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * عرض نموذج إضافة منتج
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $categories = Category::all();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * حفظ منتج جديد
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج بنجاح',
            'product' => $product->load('category')
        ], 201);
    }

    /**
     * عرض منتج محدد
     */
    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * عرض نموذج تعديل منتج
     */
    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $product = Product::with('category')->find($id);
        $categories = Category::all();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * تحديث بيانات المنتج
     */
    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|integer|min:0',
            'quantity' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->only([
            'category_id', 'title', 'price', 'quantity', 'description'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المنتج بنجاح',
            'product' => $product->load('category')
        ]);
    }

    /**
     * حذف منتج
     */
    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنتج بنجاح'
        ]);
    }

    /**
     * تحديث كمية المنتج
     */
    public function updateQuantity(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $product->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الكمية بنجاح',
            'product' => $product
        ]);
    }

    /**
     * البحث في المنتجات
     */
    public function search(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالوصول'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'search' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $products = Product::with('category')
            ->where('title', 'LIKE', '%' . $request->search . '%')
            ->orWhere('description', 'LIKE', '%' . $request->search . '%')
            ->orderBy('price', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
}
