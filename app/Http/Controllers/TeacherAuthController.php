<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\TeacherList;
use Illuminate\Support\Facades\Auth;


class TeacherAuthController extends Controller  
{

public function register(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone_number' => 'required',
        'password' => 'required|min:6',
        'code' => 'required|string', 
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    // Check if teacher exists in teacher_list with the same phone number and code
    $teacherList = TeacherList::where('phone_number', $request->phone_number)
        ->where('code', $request->code)
        ->first();

    if (!$teacherList) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid code or phone number. Please check your credentials.'
        ], 422);
    }

    // Check if teacher is already registered
    $existingTeacher = Teacher::where('phone_number', $request->phone_number)->first();
    if ($existingTeacher) {
        return response()->json([
            'success' => false,
            'message' => 'Teacher already registered with this phone number.'
        ], 422);
    }

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

    // Remove password from response
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
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('phone_number', $request->phone_number)->first();

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



  public function profile(Request $request)
{
    $teacher = Auth::guard('teacher')->user(); // ✅ مو $request->user()

    // Check if teacher exists
    if (!$teacher) {
        return response()->json([
            'success' => false,
            'message' => 'المعلم غير موجود أو غير مسجل الدخول'
        ], 401);
    }

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
            'password' => 'sometimes',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // تحديث الحقول
        if ($request->has('first_name')) {
            $teacher->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $teacher->last_name = $request->last_name;
        }

        if ($request->has('password')) {
            $teacher->password = $request->password;
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

 public function getTeachers(Request $request) 
{
    // ✅ إذا بعت id → رجّع معلّم واحد فقط
    if ($request->has('id')) {
        $teacher = TeacherList::find($request->id);

        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }

        return response()->json([
            'success' => true,
            'teacher' => $teacher
        ]);
    }

    // ✅ إذا ما في id → رجّع قائمة المعلمين مع البحث
    $query = TeacherList::query();

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('first_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('phone_number', 'LIKE', "%{$searchTerm}%"); 
        });
    }

    $teachers = $query->get();

    if ($teachers->isEmpty()) {
        return response()->json(['error' => 'No teachers found'], 404);
    }

    return response()->json([
        'success' => true,
        'teachers' => $teachers
    ]);
}



}
