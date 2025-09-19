<?php

namespace App\Http\Controllers;
use App\Models\TeacherList;
use Illuminate\Http\Request;

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



}
