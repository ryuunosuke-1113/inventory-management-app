@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">総備品数</p>
            <p class="text-2xl font-bold">{{ $totalItems }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">在庫あり</p>
            <p class="text-2xl font-bold text-green-500">{{ $availableItems }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">在庫切れ</p>
            <p class="text-2xl font-bold text-red-500">{{ $outOfStockItems }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">カテゴリー</p>
            <p class="text-2xl font-bold">{{ $totalCategories }}</p>
        </div>

    </div>
@endsection
