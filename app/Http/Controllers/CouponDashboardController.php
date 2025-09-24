<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponDashboardController extends Controller
{
    /**
     * عرض جميع الكوبونات
     */
    public function index()
    {
        $coupons = Coupon::all();

        $data = $coupons->map(function($coupon) {
            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'title' => $coupon->title,
                'discount_percentage' => $coupon->discount_percentage,
                'usage_limit' => $coupon->usage_limit,
                'used_count' => $coupon->used_count,
                'min_points' => $coupon->min_points,
                'starts_at' => $coupon->starts_at,
                'expires_at' => $coupon->expires_at,
                'is_active' => $coupon->is_active,
            ];
        });

        return response()->json([
            'success' => true,
            'coupons' => $data
        ]);
    }

    /**
     * إنشاء كوبون جديد
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'title' => 'required|string|unique:coupons,title',
            'discount_percentage' => 'required|integer|min:0|max:100',
            'usage_limit' => 'nullable|integer|min:1',
            'min_points' => 'nullable|integer|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $coupon = Coupon::create([
            'code' => $validated['code'],
            'title' => $validated['title'],
            'discount_percentage' => $validated['discount_percentage'],
            'usage_limit' => $validated['usage_limit'] ?? 1,
            'min_points' => $validated['min_points'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الكوبون بنجاح',
            'coupon' => $coupon
        ], 201);
    }

    /**
     * عرض كوبون محدد
     */
    public function show($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }

    /**
     * تحديث كوبون موجود
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        $validated = $request->validate([
            'code' => 'sometimes|required|string|unique:coupons,code,' . $coupon->id,
            'title' => 'sometimes|required|string|unique:coupons,title,' . $coupon->id,
            'discount_percentage' => 'sometimes|required|integer|min:0|max:100',
            'usage_limit' => 'nullable|integer|min:1',
            'min_points' => 'nullable|integer|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $coupon->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تعديل الكوبون بنجاح',
            'coupon' => $coupon
        ]);
    }

    /**
     * حذف كوبون
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'الكوبون غير موجود'
            ], 404);
        }

        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الكوبون بنجاح'
        ]);
    }
}
