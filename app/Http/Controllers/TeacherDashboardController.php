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

        // إذا كان الطالب مسجلاً، نضيفه إلى جدول students أيضاً
        if ($request->is_registered) {
            $student = Student::create([
                'teacher_id' => $circle->teacher_id,
                'student_name' => $request->student_name,
                'phone_number' => $request->phone_number,
                'points' => 0,
            ]);
        }

        $quranCircleStudent = QuranCircleStudent::create([
            'quran_circle'  => $circle->id,
            'teacher_id'    => $circle->teacher_id,
            'student_name'  => $request->student_name,
            'phone_number'  => $request->phone_number,
            'is_registered' => $request->is_registered ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الطالب بنجاح إلى حلقة القرآن.',
            'student' => $quranCircleStudent
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

        // إرجاع مصفوفة فارغة بدلاً من خطأ 404
        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }

    public function deleteStudent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:quran_circles_students,id', // تصحيح: يجب أن يكون exists في quran_circles_students
        ]);

        // البحث في الجدول الصحيح
        $student = QuranCircleStudent::find($request->id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير موجود'
            ], 404);
        }

        DB::transaction(function () use ($student) {
            // إذا كان الطالب مسجلاً في النظام، نحذفه من جدول students أيضاً
            if ($student->is_registered) {
                $registeredStudent = Student::where('phone_number', $student->phone_number)->first();
                if ($registeredStudent) {
                    $registeredStudent->delete();
                }
            }

            // حذف الطالب من جدول quran_circles_students
            $student->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطالب بنجاح'
        ]);
    }

    public function updateStudentPoints(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|exists:students,id',
            'points_change' => 'required|integer',
            'reason'        => 'required|string|max:255',
        ]);

        $student = Student::find($request->student_id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير موجود'
            ], 404);
        }

        $student->points += $request->points_change;
        $student->save();

        $performedBy = 'النظام';

        if ($teacher = Auth::guard('teacher')->user()) {
            $performedBy = $teacher->first_name . ' ' . $teacher->last_name;
        } elseif ($admin = Auth::guard('admin')->user()) {
            $performedBy = $admin->first_name . ' ' . $admin->last_name;
        }

        StudentPoint::create([
            'student_id'    => $student->id,
            'points_change' => $request->points_change,
            'reason'        => $request->reason,
            'performed_by'  => $performedBy,
            'changed_at'    => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث نقاط الطالب بنجاح',
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
                'message' => 'المعلم غير مسجل الدخول',
            ], 401);
        }

        $request->validate([
            'student_id' => 'sometimes|exists:students,id',
        ]);

        // البحث عن الطلاب المسجلين المرتبطين بهذا المعلم
        $studentsQuery = Student::where('teacher_id', $teacher->id);

        if ($request->filled('student_id')) {
            $studentsQuery->where('id', $request->student_id);
        }

        $students = $studentsQuery->get();

        // إعداد النتيجة مع سجل نقاط كل طالب
        $result = $students->map(function ($student) {
            $pointsHistory = StudentPoint::where('student_id', $student->id)
                ->orderBy('changed_at', 'desc')
                ->get(['points_change', 'reason', 'performed_by', 'changed_at']);

            return [
                'student_id'     => $student->id,
                'student_name'   => $student->student_name,
                'current_points' => $student->points,
                'points_history' => $pointsHistory
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $result
        ]);
    }

    // دالة جديدة لتحميل حلقات القرآن الخاصة بالمعلم
    public function getTeacherCircles()
    {
        $teacher = Auth::guard('teacher')->user();

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'المعلم غير مسجل الدخول',
            ], 401);
        }

        $circles = QuranCircle::where('teacher_id', $teacher->id)->get(['id', 'title']);

        return response()->json([
            'success' => true,
            'circles' => $circles
        ]);
    }
}
