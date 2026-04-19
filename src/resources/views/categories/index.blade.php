@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- タイトル＆新規ボタン --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">カテゴリー一覧</h1>
                <p class="text-sm text-gray-500 mt-1">備品の分類に使用するカテゴリーを管理できます。</p>
            </div>

            @can('create', App\Models\Category::class)
                <a href="{{ route('categories.create') }}"
                    class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    新規作成
                </a>
            @endcan
        </div>

        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- エラーメッセージ --}}
        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- テーブル --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-700">カテゴリー名</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-700">備品数</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-700">操作</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 text-sm text-gray-800">
                                {{ $category->id }}
                            </td>

                            <td class="p-3 text-sm text-gray-800 font-medium">
                                {{ $category->name }}
                            </td>

                            <td class="p-3 text-sm text-gray-800">
                                {{ $category->items_count ?? $category->items()->count() }} 件
                            </td>

                            <td class="p-3 text-sm">
                                <div class="flex flex-wrap gap-2">

                                    @can('update', $category)
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-green-600 hover:underline">
                                            編集
                                        </a>
                                    @endcan

                                    @can('delete', $category)
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('このカテゴリーを削除しますか？')">
                                                削除
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                カテゴリーがまだ登録されていません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
