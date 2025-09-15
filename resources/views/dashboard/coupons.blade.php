@extends('dashboard.layouts')

@section('title', 'الكوبونات')
@section('page-title', 'إدارة الكوبونات')

@section('content')
<div class="bg-white shadow rounded-lg p-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">الكود</th>
                <th class="p-2 border">الخصم</th>
                <th class="p-2 border">تاريخ الانتهاء</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2 border">1</td>
                <td class="p-2 border">SAVE50</td>
                <td class="p-2 border">50%</td>
                <td class="p-2 border">2025-12-31</td>
                <td class="p-2 border">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded">حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
