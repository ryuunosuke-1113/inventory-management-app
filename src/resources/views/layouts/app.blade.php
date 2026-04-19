<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>在庫管理アプリ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">

            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="font-bold text-gray-700">ダッシュボード</a>
                <a href="{{ route('items.index') }}" class="text-gray-600 hover:text-black">備品</a>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-black">カテゴリー</a>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-500 hover:underline">ログアウト</button>
                </form>
            </div>

        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4">
        @yield('content')
    </main>

</body>

</html>
