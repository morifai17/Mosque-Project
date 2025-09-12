@extends('dashboard.layouts')

@section('title', 'العروض')
@section('page-title', 'إدارة العروض')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white shadow rounded-xl p-6 flex flex-col">
        <h3 class="font-bold text-lg">عرض الصيف</h3>
        <p class="text-gray-500 text-sm">خصم 30% على جميع الدورات</p>
        <span class="text-green-600 font-bold mt-2">ساري حتى 30/09/2025</span>
        <button class="mt-3 bg-indigo-600 text-white px-4 py-2 rounded-lg">تعديل</button>
    </div>
</div>
@endsection
