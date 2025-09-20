<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuranCircleStudent;
use App\Models\QuranCircle;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Models\StudentPoint;
use Illuminate\Support\Facades\Auth;



class TeacherDashboardController extends Controller
{
public function addStudent(Request $request)
    {
        $request->validate([
            'quran_circle' => 'required|exists:quran_circles,id',
            'student_name' => 'required|string|max:255',
            'phone_number' => 'required|max:20',
            'is_registered' => 'sometimes|boolean',
        ]);

        $circle = QuranCircle::findOrFail($request->quran_circle);

        $student = QuranCircleStudent::create([
            'quran_circle'  => $circle->id,
            'teacher_id'    => $circle->teacher_id, // ✅ جلب الـ teacher_id من جدول quran_circles
            'student_name'  => $request->student_name,
            'phone_number'  => $request->phone_number,
            'is_registered' => $request->is_registered ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully to the Quran circle.',
            'student' => $student
        ], 201);
    }



public function getStudents(Request $request)
{
    $request->validate([
        'id'              => 'sometimes|integer|exists:quran_circles_students,id',
        'quran_circle_id' => 'sometimes|integer|exists:quran_circles,id',
        'search'          => 'sometimes|string|max:255',
    ]);

    if ($request->has('id')) {
        $student = QuranCircleStudent::find($request->id);

        return response()->json([
            'success' => true,
            'student' => $student
        ]);
    }

    $query = QuranCircleStudent::query();

    if ($request->filled('quran_circle_id')) {
        $query->where('quran_circle', $request->quran_circle_id);
    }

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('student_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('phone_number', 'LIKE', "%{$searchTerm}%");
        });
    }

    $students = $query->get();

    if ($students->isEmpty()) {
        return response()->json(['error' => 'No students found'], 404);
    }

    return response()->json([
        'success' => true,
        'students' => $students
    ]);
}

public function deleteStudent(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:students,id',
    ]);

    // جلب الطالب
    $student = Student::find($request->id);

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found'
        ], 404);
    }

    DB::transaction(function () use ($student) {
        // حذف الطالب من جدول quran_circles_students باستخدام phone_number
        QuranCircleStudent::where('phone_number', $student->phone_number)->delete();

        // حذف الطالب من جدول students
        $student->delete();
    });

    return response()->json([
        'success' => true,
        'message' => 'Student deleted successfully from both tables'
    ]);
}




public function updateStudentPoints(Request $request)
{
    $request->validate([
        'student_id'    => 'required|exists:students,id',
        'points_change' => 'required|integer',
        'reason'        => 'required|string|max:255',
    ]);

    // جلب الطالب
    $student = Student::find($request->student_id);

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found'
        ], 404);
    }

    // تحديث نقاط الطالب
    $student->points += $request->points_change;
    $student->save();

    // تحديد من قام بالتغيير تلقائيًا
    $performedBy = 'system'; // fallback

    if ($teacher = Auth::guard('teacher')->user()) {
        $performedBy = $teacher->first_name . ' ' . $teacher->last_name;
    } elseif ($admin = Auth::guard('admin')->user()) {
        $performedBy = $admin->first_name . ' ' . $admin->last_name;
    }

    // تسجيل التغيير في student_points
    StudentPoint::create([
        'student_id'    => $student->id,
        'points_change' => $request->points_change,
        'reason'        => $request->reason,
        'performed_by'  => $performedBy,
        'changed_at'    => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Student points updated successfully',
        'student' => [
            'id' => $student->id,
            'points' => $student->points
        ]
    ]);
}

public function myStudentsPoints(Request $request)
{
    $teacher = Auth::guard('teacher')->user();

    if (!$teacher) {
        return response()->json([
            'success' => false,
            'message' => 'Teacher not found or not logged in',
        ], 401);
    }

    $request->validate([
        'student_id' => 'sometimes|exists:students,id',
    ]);

    $studentsQuery = Student::where('teacher_id', $teacher->id);

    if ($request->filled('student_id')) {
        $studentsQuery->where('id', $request->student_id);
    }

    $students = $studentsQuery->get();

    if ($students->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'No students found for this teacher',
            'students' => []
        ]);
    }

    // إعداد النتيجة مع سجل نقاط كل طالب
    $result = $students->map(function ($student) {
        $pointsHistory = $student->pointsHistory()
            ->orderBy('changed_at', 'desc')
            ->get(['points_change', 'reason', 'performed_by', 'changed_at']);

        return [
            'student_id'   => $student->id,
            'student_name' => $student->student_name,
            'current_points' => $student->points,
            'points_history' => $pointsHistory
        ];
    });

    return response()->json([
        'success' => true,
        'students' => $result
    ]);
}
}
