@extends('dashboard.layouts')

@section('title', 'إدارة المدراء')
@section('page-title', 'قائمة المدراء')

@section('content')
<div class="bg-white shadow rounded-lg p-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">الاسم</th>
                <th class="p-2 border">البريد الإلكتروني</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2 border">1</td>
                <td class="p-2 border">مدير النظام</td>
                <td class="p-2 border">admin@example.com</td>
                <td class="p-2 border">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded">حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
