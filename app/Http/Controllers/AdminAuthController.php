<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = new Admin();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->admin_name = $request->first_name . ' ' . $request->last_name;
        $admin->phone_number = $request->phone_number;
        $admin->password = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');
            $admin->avatar = $path;
        }

        $admin->save();

        $token = $admin->createToken('admin-token')->plainTextToken;

        // إرجاع بيانات المشرف بدون كلمة المرور
        unset($admin->password);

        return response()->json([
            'success' => true,
            'admin' => $admin,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required|string|exists:admins,admin_name',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $admin = Admin::where('admin_name', $request->admin_name)->first();

        // التحقق من كلمة المرور
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'
            ], 401);
        }

        // معالجة صورة Avatar إذا كانت موجودة
        if ($admin->avatar) {
            $admin->avatar = Storage::disk('public')->exists($admin->avatar)
                ? asset(Storage::url($admin->avatar))
                : null;
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        // إرجاع بيانات المشرف بدون كلمة المرور
        unset($admin->password);

        return response()->json([
            'success' => true,
            'token' => $token,
            'admin' => $admin,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }

    public function getProfile(Request $request)
    {
        $admin = $request->user();

        // معالجة صورة Avatar إذا كانت موجودة
        if ($admin->avatar) {
            $admin->avatar = Storage::disk('public')->exists($admin->avatar)
                ? asset(Storage::url($admin->avatar))
                : null;
        }

        // إرجاع بيانات المشرف بدون كلمة المرور
        unset($admin->password);

        return response()->json([
            'success' => true,
            'admin' => $admin,
        ]);
    }

    // دالة للتحديث (إذا needed)
    public function updateProfile(Request $request)
    {
        $admin = $request->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // تحديث الحقول
        if ($request->has('first_name')) {
            $admin->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $admin->last_name = $request->last_name;
        }

        if ($request->has('phone_number')) {
            $admin->phone_number = $request->phone_number;
        }

        // تحديث الصورة إذا تم رفع جديدة
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');
            $admin->avatar = $path;
        }

        $admin->save();

        // معالجة صورة Avatar للعرض
        if ($admin->avatar) {
            $admin->avatar = asset(Storage::url($admin->avatar));
        }

        unset($admin->password);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'admin' => $admin,
        ]);
    }
}
