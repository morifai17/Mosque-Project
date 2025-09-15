@extends('dashboard.layouts')

@section('title', 'المستخدمين')
@section('page-title', 'قائمة المستخدمين')

@section('content')
<div class="bg-white shadow rounded-lg p-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">الاسم</th>
                <th class="p-2 border">البريد الإلكتروني</th>
                <th class="p-2 border">الدور</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2 border">1</td>
                <td class="p-2 border">محمد علي</td>
                <td class="p-2 border">mohammed@example.com</td>
                <td class="p-2 border">طالب</td>
                <td class="p-2 border">
                    <button class="bg-yellow-500 text-white px-3 py-1 rounded">تغيير الدور</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded">حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
