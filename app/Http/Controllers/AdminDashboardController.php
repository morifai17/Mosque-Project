<?php

namespace App\Http\Controllers;
use App\Models\TeacherList;
use App\Models\QuranCircle;
use Illuminate\Http\Request;
use App\Models\StudentPoint;

class AdminDashboardController extends Controller
{

    public function addTeacher(Request $request)
{
    $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'phone_number' => 'required|max:20',
        'code'         => 'required|string|unique:teacher_list,code|max:50',
        'circle_title' => 'required|string|max:255', // ✅ عنوان الحلقة
    ]);

    // إنشاء المعلّم
    $teacher = TeacherList::create([
        'first_name'   => $request->first_name,
        'last_name'    => $request->last_name,
        'phone_number' => $request->phone_number,
        'code'         => $request->code,
    ]);

    // إنشاء حلقة قرآن مرتبطة بالمعلّم
    $quranCircle = \App\Models\QuranCircle::create([
        'title'      => $request->circle_title,
        'teacher_id' => $teacher->id,
    ]);

    return response()->json([
        'success' => true,
        'teacher' => $teacher,
        'quran_circle' => $quranCircle,
    ], 201);
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


public function getQuranCircles()
{
    // جلب الحلقات مع بيانات المعلم (first_name, last_name)
    $circles = QuranCircle::with('teacher:id,first_name,last_name')->get();

    if ($circles->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No Quran circles found'
        ], 404);
    }

    // تحويل النتائج لمصفوفة وإضافة teacher_name لكل حلقة
    $circlesArray = $circles->map(function($circle) {
        return [
            'id' => $circle->id,
            'title' => $circle->title,
            'teacher_id' => $circle->teacher_id,
            'teacher_name' => $circle->teacher 
                ? $circle->teacher->first_name . ' ' . $circle->teacher->last_name 
                : null,
            'created_at' => $circle->created_at,
            'updated_at' => $circle->updated_at,
        ];
    });

    return response()->json([
        'success' => true,
        'circles' => $circlesArray
    ]);
}


public function pointsChanges(Request $request)
{
    // تحقق من صحة student_id إذا أرسل
    $request->validate([
        'student_id' => 'sometimes|exists:students,id',
    ]);

    $query = StudentPoint::query();

    if ($request->filled('student_id')) {
        $query->where('student_id', $request->student_id);
    }

    // جلب البيانات مع علاقة الطالب
    $pointsHistory = $query->with('student:id,student_name')
        ->orderBy('changed_at', 'desc')
        ->get(['id', 'student_id', 'points_change', 'reason', 'performed_by', 'changed_at']);

    if ($pointsHistory->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'No points history found',
            'history' => []
        ]);
    }

    // إعادة تشكيل النتيجة لإظهار اسم الطالب مباشرة
    $result = $pointsHistory->map(function ($item) {
        return [
            'student_id'    => $item->student_id,
            'student_name'  => $item->student ? $item->student->student_name : null,
            'points_change' => $item->points_change,
            'reason'        => $item->reason,
            'performed_by'  => $item->performed_by,
            'changed_at'    => $item->changed_at,
        ];
    });

    return response()->json([
        'success' => true,
        'history' => $result
    ]);
}

}
