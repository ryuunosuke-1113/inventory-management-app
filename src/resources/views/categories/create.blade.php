@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">カテゴリー登録</h1>

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
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリー名</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                        placeholder="カテゴリー名を入力">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        登録
                    </button>

                    <a href="{{ route('categories.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        戻る
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
