@extends('dashboard.layout')

@section('title', 'المنتجات')
@section('page-title', 'إدارة المنتجات')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="font-bold text-lg mb-2">منتج 1</h2>
        <p class="text-gray-600">وصف قصير للمنتج.</p>
        <div class="mt-3 flex justify-between items-center">
            <span class="text-green-600 font-bold">150 ريال</span>
            <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="font-bold text-lg mb-2">منتج 2</h2>
        <p class="text-gray-600">وصف قصير للمنتج.</p>
        <div class="mt-3 flex justify-between items-center">
            <span class="text-green-600 font-bold">200 ريال</span>
            <button class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</button>
        </div>
    </div>
</div>
@endsection
