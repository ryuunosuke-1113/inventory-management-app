@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">備品詳細</h1>

            <a href="{{ route('items.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                一覧へ戻る
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">ID</p>
                    <p class="font-medium">{{ $item->id }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">備品コード</p>
                    <p class="font-medium">{{ $item->item_code }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">備品名</p>
                    <p class="font-medium">{{ $item->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">カテゴリー</p>
                    <p class="font-medium">{{ $item->category?->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">在庫数</p>
                    <p class="font-medium">{{ $item->stock }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">ステータス</p>
                    <p class="font-medium">
                        @if ($item->status === 'out_of_stock')
                            <span class="text-red-500 font-bold">{{ $item->status_label }}</span>
                        @else
                            {{ $item->status_label }}
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">保管場所</p>
                    <p class="font-medium">{{ $item->location ?: '—' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-1">備考</p>
                <div class="border rounded p-3 bg-gray-50 min-h-[80px]">
                    {{ $item->note ?: '記載なし' }}
                </div>
            </div>

            @can('update', $item)
                <div class="mt-6">
                    <a href="{{ route('items.edit', $item) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        編集する
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
