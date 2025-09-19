<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuranCircleStudent;
use App\Models\QuranCircle;

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


}
