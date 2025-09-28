<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
{
    $student = Auth::guard(name: 'student')->user(); // ✅ الطالب من التوكن

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not authenticated',
        ], 401);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($request->product_id);

    // ✅ تحقق من الكمية المتاحة
    if ($request->quantity > $product->quantity) {
        return response()->json([
            'success' => false,
            'message' => 'Requested quantity exceeds available stock',
            'available_quantity' => $product->quantity
        ], 400);
    }

    // ✅ هل المنتج موجود مسبقًا في كرت الطالب؟
    $cartItem = Cart::where('student_id', $student->id)
        ->where('product_id', $product->id)
        ->first();

    if ($cartItem) {
        // 🔄 تحديث الكمية والسعر الكلي
        $newQuantity = $cartItem->quantity + $request->quantity;

        // تحقق بعد الجمع
        if ($newQuantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock for this product',
                'available_quantity' => $product->quantity
            ], 400);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->total_price = $newQuantity * $product->price;
        $cartItem->save();

        $message = 'Cart updated successfully';
    } else {
        // 🆕 إضافة منتج جديد إلى الكرت
        $cartItem = Cart::create([
            'student_id'  => $student->id,
            'product_id'  => $product->id,
            'quantity'    => $request->quantity,
            'total_price' => $request->quantity * $product->price,
        ]);

        $message = 'Product added to cart successfully';
    }

    return response()->json([
        'success' => true,
        'message' => $message,
        'cart_item' => $cartItem,
    ]);
}


public function remove(Request $request)
{
    $student = Auth::guard('student')->user(); // ✅ الطالب من التوكن

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not authenticated',
        ], 401);
    }

    // ✅ إذا ما فيه product_id → فضي الكرت كامل
    if (!$request->filled('product_id')) {
        Cart::where('student_id', $student->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart emptied successfully',
        ]);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'sometimes|integer|min:1',
    ]);

    // ✅ جلب المنتج من الكرت
    $cartItem = Cart::where('student_id', $student->id)
        ->where('product_id', $request->product_id)
        ->first();

    if (!$cartItem) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart',
        ], 404);
    }

    if ($request->filled('quantity')) {
        // 🔄 تقليل الكمية
        $newQuantity = $cartItem->quantity - $request->quantity;

        if ($newQuantity > 0) {
            $product = Product::findOrFail($request->product_id);
            $cartItem->quantity = $newQuantity;
            $cartItem->total_price = $newQuantity * $product->price;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_item' => $cartItem,
            ]);
        }
    }

    // 🗑️ حذف المنتج كامل من الكرت
    $cartItem->delete();

    return response()->json([
        'success' => true,
        'message' => 'Product removed from cart successfully',
    ]);
}


public function get(Request $request)
{
    $student = Auth::guard('student')->user();

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not authenticated',
        ], 401);
    }

    $cartItems = Cart::where('student_id', $student->id)
        ->with('product') // لازم تعرف relation في Cart model
        ->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'Cart is empty',
            'cart_items' => [],
            'cart_total' => 0,
        ]);
    }

    $cartTotal = 0;

    $items = $cartItems->map(function ($item) use (&$cartTotal) {
        $unitPrice = $item->product->price;
        $totalItemPrice = $unitPrice * $item->quantity;

        $cartTotal += $totalItemPrice;

        return [
            'product_id'       => $item->product->id,
            'product_name'     => $item->product->title,
            'unit_price'       => $unitPrice,
            'quantity'         => $item->quantity,
            'total_item_price' => $totalItemPrice,
        ];
    });

    return response()->json([
        'success' => true,
        'cart_items' => $items,
        'cart_total' => $cartTotal,
    ]);
}
}
