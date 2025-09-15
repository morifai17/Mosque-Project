<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        try {
            // إضافة with('images') لتحميل الصور مع المنتجات
            $products = Product::with(['category', 'images'])->get();

            return response()->json([
                'success' => true,
                'products' => $products,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في جلب البيانات: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        // إضافة with('images') لتحميل الصور مع المنتجات
        $products = Product::with(['category', 'images'])
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->search . '%')
                              ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                    });
                })
                ->when($request->category_id, function ($query) use ($request) {
                    $query->where('category_id', $request->category_id);
                })
                ->orderBy('price', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
    }

    /**
     * دالة جديدة لإضافة صورة لمنتج
     */
    public function addImage(Request $request, $productId)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $product = Product::findOrFail($productId);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');

                $productImage = new ProductImage();
                $productImage->product_id = $productId;
                $productImage->image_path = $imagePath;
                $productImage->save();

                return response()->json([
                    'success' => true,
                    'message' => 'تم إضافة الصورة بنجاح',
                    'image' => $productImage
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'لم يتم تحميل أي صورة'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في إضافة الصورة: ' . $e->getMessage()
            ], 500);
        }
    }
}
