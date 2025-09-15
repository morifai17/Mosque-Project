@extends('dashboard.layouts')

@section('title', 'الطلبات')
@section('page-title', 'قائمة الطلبات')

@section('content')
<div class="bg-white shadow rounded-lg p-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">#</th>
                <th class="p-2 border">المستخدم</th>
                <th class="p-2 border">المنتج</th>
                <th class="p-2 border">المبلغ</th>
                <th class="p-2 border">الحالة</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="p-2 border">1</td>
                <td class="p-2 border">أحمد</td>
                <td class="p-2 border">منتج 1</td>
                <td class="p-2 border">150 ريال</td>
                <td class="p-2 border text-green-600">مكتمل</td>
                <td class="p-2 border">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded">عرض</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
