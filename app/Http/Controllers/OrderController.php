<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\StudentPoint;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function save(Request $request)
{
    // ✅ التحقق من البيانات المدخلة
    $request->validate([
        'coupon_code' => 'nullable|string|exists:coupons,code',
    ]);

    $student = Auth::guard('student')->user(); // الطالب من التوكن

    // اجمع بيانات السلة
    $cartItems = Cart::with('product')->where('student_id', $student->id)->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);
    }

    $totalPrice = $cartItems->sum('total_price');
    $finalPrice = $totalPrice;
    $couponId = null;
    $couponCode = $request->coupon_code;

    // تحقق من الكوبون إذا موجود
    if ($couponCode) {
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon'], 400);
        }

        if ($coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Coupon usage limit reached'], 400);
        }

        if ($coupon->min_points && $student->points < $coupon->min_points) {
            return response()->json(['success' => false, 'message' => 'Not enough points for this coupon'], 400);
        }

        $discount = ($totalPrice * $coupon->discount_percentage) / 100;
        $finalPrice -= $discount;

        // حدث بيانات الكوبون
        $coupon->increment('used_count');
        $couponId = $coupon->id;
    }

    // تحقق من رصيد النقاط
    if ($student->points < $finalPrice) {
        return response()->json(['success' => false, 'message' => 'Not enough points'], 400);
    }

    // تحقق من توفر كمية المنتجات قبل إنشاء الطلب
    foreach ($cartItems as $item) {
        if ($item->product->quantity < $item->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Not enough quantity for product {$item->product->name}"
            ], 400);
        }
    }

    // أنشئ الطلب
    $order = Order::create([
        'student_id'  => $student->id,
        'total_price' => $totalPrice,
        'coupon_id'   => $couponId,
        'final_price' => $finalPrice,
    ]);

    // حفظ المنتجات في order_product وتحديث الكمية
    foreach ($cartItems as $item) {
        OrderProduct::create([
            'order_id'   => $order->id,
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'price'      => $item->product->price,
        ]);

        // خصم الكمية من المنتج
        $product = $item->product;
        $product->quantity -= $item->quantity;
        $product->save();
    }

    // حالة الطلب
    OrderStatus::create([
        'order_id'   => $order->id,
        'student_id' => $student->id,
        'status'     => 'pending',
    ]);

    // خصم النقاط من الطالب
    $student->points -= $finalPrice;
    $student->save();

    // سجل حركة النقاط
    StudentPoint::create([
        'student_id'    => $student->id,
        'points_change' => -$finalPrice,
        'reason'        => 'Order checkout (Order #' . $order->id . ')',
        'performed_by'  => 'student',
        'changed_at'    => now(),
    ]);

    // امسح السلة
    Cart::where('student_id', $student->id)->delete();

    return response()->json([
        'success'      => true,
        'message'      => 'Order approved successfully',
        'order_id'     => $order->id,
        'final_price'  => $finalPrice,
        'coupon_used'  => $couponCode ?? null,
    ], 201);
}


public function myOrders()
{
    $student = Auth::guard('student')->user(); // الطالب من التوكن

    $orders = Order::where('student_id', $student->id)
        ->with(['products', 'latestStatus', 'coupon'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($order) {
            return [
                'id'          => $order->id,
                'total_price' => $order->total_price,
                'final_price' => $order->final_price,
                'discount'    => $order->coupon ? $order->coupon->discount_percentage . '%' : null,
                'status'      => $order->latestStatus ? $order->latestStatus->status : 'pending',
                'created_at'  => $order->created_at->toDateTimeString(),
                'products'    => $order->products->map(function ($product) {
                    return [
                        'id'       => $product->id,
                        'name'     => $product->name ?? $product->title ?? $product->product_name, // ✅ غطينا أكثر من احتمال
                        'price'    => $product->pivot->price,
                        'quantity' => $product->pivot->quantity,
                        'subtotal' => $product->pivot->price * $product->pivot->quantity,
                    ];
                }),
            ];
        });

    return response()->json([
        'success' => true,
        'orders'  => $orders,
    ]);
}


public function cancel(Request $request)
{
    // ✅ التحقق من الـ id
    $request->validate([
        'order_id' => 'required|integer|exists:orders,id',
    ]);

    $student = Auth::guard('student')->user(); // ✅ الطالب من التوكن

    $order = Order::with(['products', 'latestStatus'])
        ->where('student_id', $student->id)
        ->findOrFail($request->order_id);

    // تحقق إن الطلب قابل للإلغاء
    if (!in_array($order->latestStatus?->status, ['pending', 'accepted'])) {
        return response()->json([
            'success' => false,
            'message' => 'This order cannot be cancelled',
        ], 400);
    }

    // ✅ أعد النقاط للطالب
    $student->points += $order->final_price;
    $student->save();

    // سجل حركة النقاط
    StudentPoint::create([
        'student_id'    => $student->id,
        'points_change' => +$order->final_price,
        'reason'        => 'Order cancelled (Order #' . $order->id . ')',
        'performed_by'  => 'student',
        'changed_at'    => now(),
    ]);

    // ✅ أعد المنتجات للمخزون
    foreach ($order->products as $product) {
        $product->quantity += $product->pivot->quantity;
        $product->save();
    }

    // ✅ أضف status جديد "cancelled"
    OrderStatus::create([
        'order_id'   => $order->id,
        'student_id' => $student->id,
        'status'     => 'cancelled',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Order cancelled successfully',
    ]);
}




public function updateOrderStatus(Request $request)
{
    $request->validate([
        'order_id' => 'required|integer|exists:orders,id',
        'status'   => 'required|in:accepted,rejected,delivered',
    ]);

    $order = Order::with('latestStatus')->findOrFail($request->order_id);

    // تحقق إذا الطلب لسه pending
    if ($order->latestStatus && $order->latestStatus->status !== 'pending') {
        return response()->json([
            'success' => false,
            'message' => 'This order has already been processed.',
        ], 400);
    }

    // أضف حالة جديدة
    OrderStatus::create([
        'order_id'   => $order->id,
        'student_id' => $order->student_id,
        'status'     => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => "Order has been {$request->status} successfully",
        'order_id' => $order->id,
        'new_status' => $request->status,
    ]);
}


public function getOrders(Request $request)
{
    $query = Order::with([
        'student:id,student_name',
        'products:id,title',
        'latestStatus'   // ✅ أضفنا العلاقة
    ]);

    if ($request->filled('student_id')) {
        $query->where('student_id', $request->student_id);
    }

    $orders = $query->get();

    return response()->json([
        'status' => 'success',
        'data' => $orders
    ]);
}



}
