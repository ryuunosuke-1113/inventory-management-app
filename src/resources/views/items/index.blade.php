@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">備品一覧</h1>
                <p class="text-sm text-gray-500 mt-1">備品の検索・確認・管理ができます。</p>
            </div>

            @can('create', App\Models\Item::class)
                <a href="{{ route('items.create') }}"
                    class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    新規作成
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <form action="{{ route('items.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">キーワード検索</label>
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="備品名・備品コード・保管場所"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリー</label>
                    <select name="category_id"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">すべて</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (string) ($categoryId ?? '') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        検索
                    </button>

                    <a href="{{ route('items.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        リセット
                    </a>
                </div>
            </form>

            <div class="mt-4">
                <form action="{{ route('items.export.csv') }}" method="GET">
                    <input type="hidden" name="keyword" value="{{ $keyword ?? '' }}">
                    <input type="hidden" name="category_id" value="{{ $categoryId ?? '' }}">

                    <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600">
                        CSV出力
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">備品コード</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">備品名</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">カテゴリー</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">在庫数</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">保管場所</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">ステータス</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">備考</th>
                            <th class="p-3 text-left text-sm font-semibold text-gray-700">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-800">{{ $item->id }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $item->item_code }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $item->name }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $item->category?->name }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $item->stock }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $item->location ?: '—' }}</td>

                                <td class="p-3 text-sm">
                                    @if ($item->status === 'out_of_stock')
                                        <span class="text-red-500 font-bold">
                                            {{ $item->status_label }}
                                        </span>
                                    @elseif($item->status === 'available')
                                        <span class="text-green-600 font-medium">
                                            {{ $item->status_label }}
                                        </span>
                                    @elseif($item->status === 'discontinued')
                                        <span class="text-gray-500 font-medium">
                                            {{ $item->status_label }}
                                        </span>
                                    @else
                                        <span class="text-gray-800">
                                            {{ $item->status_label }}
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3 text-sm text-gray-800">
                                    {{ $item->note ?: '—' }}
                                </td>

                                <td class="p-3 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:underline">
                                            詳細
                                        </a>

                                        @can('update', $item)
                                            <a href="{{ route('items.edit', $item) }}" class="text-green-600 hover:underline">
                                                編集
                                            </a>
                                        @endcan

                                        @can('delete', $item)
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline"
                                                    onclick="return confirm('この備品を削除しますか？')">
                                                    削除
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-6 text-center text-gray-500">
                                    該当する備品がありません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>
@endsection
