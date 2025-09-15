<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthStudentController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:teachers,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'age' => 'required|integer|min:5|max:25',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // التحقق من وجود المعلم
        $teacher = Teacher::find($request->teacher_id);
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'المعلم غير موجود'
            ], 404);
        }

        $student = new Student();
        $student->teacher_id = $request->teacher_id;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->student_name = $request->first_name . ' ' . $request->last_name;;
        $student->phone_number = $request->phone_number;
        $student->age = $request->age;
        $student->password = Hash::make($request->password);
        $student->points = 0;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('student_avatars', 'public');
            $student->avatar = $path;
        }

        $student->save();

        $token = $student->createToken('student-token')->plainTextToken;

        // إرجاع البيانات بدون كلمة المرور
        unset($student->password);

        return response()->json([
            'success' => true,
            'student' => $student,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|exists:students,student_name',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $student = Student::where('student_name', $request->student_name)->first();

        // التحقق من كلمة المرور
        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json([
                'success' => false,
                'message' => 'اسم الطالب أو كلمة المرور غير صحيحة'
            ], 401);
        }

        // معالجة صورة Avatar إذا كانت موجودة
        if ($student->avatar) {
            $student->avatar = Storage::disk('public')->exists($student->avatar)
                ? asset(Storage::url($student->avatar))
                : null;
        }

        $token = $student->createToken('student-token')->plainTextToken;

        // إرجاع البيانات بدون كلمة المرور
        unset($student->password);

        return response()->json([
            'success' => true,
            'token' => $token,
            'student' => $student,
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
        $student = $request->user();

        // تحميل بيانات المعلم المرتبط
        $student->load('teacher');

        // معالجة صورة Avatar إذا كانت موجودة
        if ($student->avatar) {
            $student->avatar = Storage::disk('public')->exists($student->avatar)
                ? asset(Storage::url($student->avatar))
                : null;
        }

        // إرجاع البيانات بدون كلمة المرور
        unset($student->password);

        return response()->json([
            'success' => true,
            'student' => $student,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $student = $request->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string',
            'age' => 'sometimes|integer|min:5|max:25',
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
            $student->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $student->last_name = $request->last_name;
        }

        if ($request->has('phone_number')) {
            $student->phone_number = $request->phone_number;
        }

        if ($request->has('age')) {
            $student->age = $request->age;
        }

        // تحديث الصورة إذا تم رفع جديدة
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
                Storage::disk('public')->delete($student->avatar);
            }

            $avatar = $request->file('avatar');
            $path = $avatar->store('student_avatars', 'public');
            $student->avatar = $path;
        }

        $student->save();

        // معالجة صورة Avatar للعرض
        if ($student->avatar) {
            $student->avatar = asset(Storage::url($student->avatar));
        }

        unset($student->password);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'student' => $student,
        ]);
    }

    public function updatePoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'points' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $student = $request->user();
        $student->points = $request->points;
        $student->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث النقاط بنجاح',
            'points' => $student->points,
        ]);
    }

    public function getStudentsByTeacher(Request $request, $teacherId)
    {
        $validator = Validator::make(['teacher_id' => $teacherId], [
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $students = Student::where('teacher_id', $teacherId)
            ->get()
            ->map(function ($student) {
                if ($student->avatar) {
                    $student->avatar = Storage::disk('public')->exists($student->avatar)
                        ? asset(Storage::url($student->avatar))
                        : null;
                }
                unset($student->password);
                return $student;
            });

        return response()->json([
            'success' => true,
            'students' => $students,
        ]);
    }
}
