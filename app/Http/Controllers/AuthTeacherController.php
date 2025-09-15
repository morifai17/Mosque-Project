<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthTeacherController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $teacher = new Teacher();
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->teacher_name = $request->first_name . ' ' . $request->last_name;
        $teacher->phone_number = $request->phone_number;
        $teacher->password = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('teacher_avatars', 'public');
            $teacher->avatar = $path;
        }

        $teacher->save();

        $token = $teacher->createToken('teacher-token')->plainTextToken;

        // إرجاع البيانات بدون كلمة المرور
        unset($teacher->password);

        return response()->json([
            'success' => true,
            'teacher' => $teacher,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required|string|exists:teachers,teacher_name',
            'password' => 'required|string',
        ]);

        $teacher = Teacher::where('teacher_name', $request->teacher_name)->first();

        // التحقق من كلمة المرور
        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return response()->json([
                'success' => false,
                'message' => 'اسم المعلم أو كلمة المرور غير صحيحة'
            ], 401);
        }

        // معالجة صورة Avatar إذا كانت موجودة
        if ($teacher->avatar) {
            $teacher->avatar = Storage::disk('public')->exists($teacher->avatar)
                ? asset(Storage::url($teacher->avatar))
                : null;
        }

        $token = $teacher->createToken('teacher-token')->plainTextToken;

        // إرجاع البيانات بدون كلمة المرور
        unset($teacher->password);

        return response()->json([
            'success' => true,
            'token' => $token,
            'teacher' => $teacher,
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
        $teacher = $request->user();

        // معالجة صورة Avatar إذا كانت موجودة
        if ($teacher->avatar) {
            $teacher->avatar = Storage::disk('public')->exists($teacher->avatar)
                ? asset(Storage::url($teacher->avatar))
                : null;
        }

        // إرجاع البيانات بدون كلمة المرور
        unset($teacher->password);

        return response()->json([
            'success' => true,
            'teacher' => $teacher,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $teacher = $request->user();

        $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // تحديث الحقول
        if ($request->has('first_name')) {
            $teacher->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $teacher->last_name = $request->last_name;
        }

        if ($request->has('phone_number')) {
            $teacher->phone_number = $request->phone_number;
        }

        // تحديث الصورة إذا تم رفع جديدة
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($teacher->avatar && Storage::disk('public')->exists($teacher->avatar)) {
                Storage::disk('public')->delete($teacher->avatar);
            }

            $avatar = $request->file('avatar');
            $path = $avatar->store('teacher_avatars', 'public');
            $teacher->avatar = $path;
        }

        $teacher->save();

        // معالجة صورة Avatar للعرض
        if ($teacher->avatar) {
            $teacher->avatar = asset(Storage::url($teacher->avatar));
        }

        unset($teacher->password);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'teacher' => $teacher,
        ]);
    }

    public function getAllTeachers(Request $request)
    {
        $teachers = Teacher::all()->map(function ($teacher) {
            if ($teacher->avatar) {
                $teacher->avatar = Storage::disk('public')->exists($teacher->avatar)
                    ? asset(Storage::url($teacher->avatar))
                    : null;
            }
            unset($teacher->password);
            return $teacher;
        });

        return response()->json([
            'success' => true,
            'teachers' => $teachers,
        ]);
    }

    public function getTeacherById($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'المعلم غير موجود'
            ], 404);
        }

        // معالجة صورة Avatar إذا كانت موجودة
        if ($teacher->avatar) {
            $teacher->avatar = Storage::disk('public')->exists($teacher->avatar)
                ? asset(Storage::url($teacher->avatar))
                : null;
        }

        unset($teacher->password);

        return response()->json([
            'success' => true,
            'teacher' => $teacher,
        ]);
    }
}
