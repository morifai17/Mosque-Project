@extends('dashboard.layouts')

@section('title', 'العروض')
@section('page-title', 'إدارة العروض')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="font-bold text-lg mb-2">عرض خاص</h2>
        <p class="text-gray-600">خصم 20% على جميع المنتجات.</p>
        <div class="mt-3 flex justify-between items-center">
            <span class="text-red-500 font-bold">حتى 2025-12-31</span>
            <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
        </div>
    </div>
</div>
@endsection
