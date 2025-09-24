<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryDashboardController extends Controller
{
    /**
     * عرض جميع الفئات
     */
    public function index()
    {
        $categories = Category::all();

        $data = $categories->map(function($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'image' => $category->image,
            ];
        });

        return response()->json([
            'success' => true,
            'categories' => $data
        ]);
    }

  
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::create([
            'title' => $validated['title'],
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->update(['image' => $imagePath]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الفئة بنجاح',
            'category' => $category
        ], 201);
    }

    /**
     * عرض فئة محددة
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'الفئة غير موجودة'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    /**
     * تحديث فئة موجودة
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'الفئة غير موجودة'
            ], 404);
        }

        $category->update($request->only(['title']));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
            $category->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تعديل الفئة بنجاح',
            'category' => $category
        ]);
    }

    /**
     * حذف فئة
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'الفئة غير موجودة'
            ], 404);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الفئة بنجاح'
        ]);
    }
}
