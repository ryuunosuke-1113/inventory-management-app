@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">備品登録</h1>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('items.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">備品コード</label>
                    <input type="text" name="item_code" value="{{ old('item_code') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">備品名</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリー</label>
                    <select name="category_id"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">選択してください</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">在庫数</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">保管場所</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
                    <select name="status"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>在庫あり</option>
                        <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>在庫切れ</option>
                        <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>廃番</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">備考</label>
                    <textarea name="note" rows="4"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('note') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        登録
                    </button>

                    <a href="{{ route('items.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
