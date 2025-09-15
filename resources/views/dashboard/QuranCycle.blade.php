@extends('dashboard.layouts')

@section('title', 'دورات القرآن')
@section('page-title', 'إدارة دورات القرآن')

@section('content')
<div class="bg-white shadow rounded-lg p-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">اسم الدورة</th>
                <th class="p-2 border">المدرس</th>
                <th class="p-2 border">عدد الطلاب</th>
                <th class="p-2 border">تاريخ البدء</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2 border">1</td>
                <td class="p-2 border">حفظ جزء عم</td>
                <td class="p-2 border">الشيخ محمود</td>
                <td class="p-2 border">25</td>
                <td class="p-2 border">2025-10-01</td>
                <td class="p-2 border">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded">حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
