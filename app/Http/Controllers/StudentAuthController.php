<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuranCircleStudent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentAuthController extends Controller
{

public function register(Request $request)
{
    // Validate input
    $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'phone_number' => 'required|max:20|unique:students,phone_number',
        'age'          => 'required|integer|min:1',
        'password'     => 'required',
        'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Check if phone number exists in quran_circle_students
    $circleStudent = QuranCircleStudent::where('phone_number', $request->phone_number)->first();

    if (!$circleStudent) {
        return response()->json([
            'success' => false,
            'message' => 'Cannot register: phone number not found in Quran circle students.'
        ], 422);
    }

    // Create new student
    $student = new Student();
    $student->teacher_id   = $circleStudent->teacher_id;
    $student->first_name   = $request->first_name;
    $student->last_name    = $request->last_name;
    $student->student_name = $request->first_name . ' ' . $request->last_name;
    $student->phone_number = $request->phone_number;
    $student->age          = $request->age;
    $student->password     = Hash::make($request->password);
    $student->points       = 0;

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $path = $avatar->store('avatars', 'public');
        $student->avatar = $path;
    }

    $student->save();

    // Generate student token
    $token = $student->createToken('student_token')->plainTextToken;

    // Mark student as registered in quran_circle_students
    $circleStudent->is_registered = 1;
    $circleStudent->save();

    return response()->json([
        'success' => true,
        'message' => 'Student registered successfully.',
        'student' => $student,
        'token'   => $token
    ], 201);
}



 public function login(Request $request)
{
    // Validate input
    $request->validate([
        'phone_number' => 'required',
        'password'     => 'required',
    ]);

    // Find student by phone number
    $student = Student::where('phone_number', $request->phone_number)->first();

    if (!$student || !Hash::check($request->password, $student->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid phone number or password.'
        ], 401);
    }

    // Generate new token
    $token = $student->createToken('student_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful.',
        'student' => $student,
        'token'   => $token
    ], 200);
}

   public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }



public function profile(Request $request)
{
    $student = Auth::guard('student')->user(); // ✅ use the student guard

    // Check if student exists
    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'الطالب غير موجود أو غير مسجل الدخول'
        ], 401);
    }

    // Handle Avatar if exists
    if ($student->avatar) {
        $student->avatar = Storage::disk('public')->exists($student->avatar)
            ? asset(Storage::url($student->avatar))
            : null;
    }

    // Hide password before returning
    unset($student->password);

    return response()->json([
        'success' => true,
        'student' => $student,
    ]);
}

   

public function updateProfile(Request $request)
{
    $student = Auth::guard('student')->user(); // ✅ use student guard

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'الطالب غير موجود أو غير مسجل الدخول'
        ], 401);
    }

    $request->validate([
        'first_name'   => 'sometimes|string|max:255',
        'last_name'    => 'sometimes|string|max:255',
        'phone_number' => 'sometimes|string',
        'avatar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'age'          => 'sometimes|integer|min:1',
    ]);

    // ✅ Update fields if present
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


    // ✅ Update full student_name automatically
    if ($request->has('first_name') || $request->has('last_name')) {
        $student->student_name = trim($student->first_name . ' ' . $student->last_name);
    }

    // ✅ Handle avatar upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar if exists
        if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
            Storage::disk('public')->delete($student->avatar);
        }

        $avatar = $request->file('avatar');
        $path = $avatar->store('student_avatars', 'public');
        $student->avatar = $path;
    }

    $student->save();

    // ✅ Format avatar URL for response
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
