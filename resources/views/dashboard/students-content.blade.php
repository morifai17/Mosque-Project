@extends('dashboard.layouts')

@section('title', 'محتوى الطلاب')
@section('page-title', 'إدارة محتوى الطلاب')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="font-bold text-lg mb-2">مقال تعليمي</h2>
        <p class="text-gray-600">شرح مبسط لقواعد التجويد.</p>
        <div class="mt-3 flex justify-between items-center">
            <span class="text-sm text-gray-500">2025-09-01</span>
            <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="font-bold text-lg mb-2">فيديو تدريبي</h2>
        <p class="text-gray-600">درس مرئي حول مخارج الحروف.</p>
        <div class="mt-3 flex justify-between items-center">
            <span class="text-sm text-gray-500">2025-09-10</span>
            <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
        </div>
    </div>
</div>
@endsection
