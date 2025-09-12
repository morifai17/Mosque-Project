@extends('dashboard.layouts')

@section('title', 'الأدمنز')
@section('page-title', 'إدارة الأدمنز')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100 text-gray-600 uppercase">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">الاسم</th>
                <th class="px-4 py-2">الصلاحيات</th>
                <th class="px-4 py-2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">1</td>
                <td class="px-4 py-2">أحمد</td>
                <td class="px-4 py-2">مدير النظام</td>
                <td class="px-4 py-2">
                    <button class="text-indigo-600 hover:underline">تعديل</button> |
                    <button class="text-red-600 hover:underline">حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
