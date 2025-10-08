<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminAuthController extends Controller
{

    public function register(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone_number' => 'required|numeric   ',
        'password' => 'required|min:6',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    $admin = new Admin();
    $admin->first_name = $validated['first_name'];
    $admin->last_name = $validated['last_name'];
    $admin->admin_name = $validated['first_name'] . ' ' . $validated['last_name'];
    $admin->phone_number = $validated['phone_number'];
    $admin->password = Hash::make($validated['password']);
    $admin->Super_Admin = false; // Explicitly set to false as required

    if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');
            $admin->avatar = $path;
        }
    $admin->save();

    $token = $admin->createToken('admin-token')->plainTextToken;

    // Remove password from response
    unset($admin->password);

    return response()->json([
        'success' => true,
        'admin' => $admin,
        'token' => $token,
    ], 201);
}


public function login(Request $request)
{
    $request->validate([
        'phone_number' => 'required|numeric|exists:admins',
        'password' => 'nullable|required_without:fingerprint',
    ]);

    // Find the admin by phone number
    $admin = Admin::where('phone_number', $request->phone_number)->first();

    if ($admin) {
        // Check password normally (not hashed)
        if ($request->filled('password')) {
            if ($request->password !== $admin->password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong password',
                ], 200);
            }
        }

        $admin->avatar = asset($admin->avatar);

        return response()->json([
            'success' => true,
            'token' => $admin->createToken('admin Token')->plainTextToken,
            'user' => $admin,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Wrong information',
    ], 200);
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'logged out succefully'
        ]);
    }

    public function profile(Request $request)
    {
        $admin = $request->user();

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

    public function updateProfile(Request $request)
    {
        $admin = $request->user();

    $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);



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
            'message' => 'profile updated successfully',
            'admin' => $admin,
        ]);
    }
}

