<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common_scroll.css') }}">
    @yield('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <header>
        <div class="header__left">
            <div class="header__menu">
                <form action="/menu">
                    <button class="menu__button">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </form>
            </div>
            <div class="app-title__space">
                <span class="app-title">Rese</span>
            </div>
            @can('admin')
            <div class="specialty">
                <form action="admin/home" method="get">
                    <button class="specialty-button">管理者メニュー</button>
                </form>
            </div>
            @endcan
            @can('store-representative')
            <div class="specialty">
                <form action="store-representative/home" method="get">
                    <button class="specialty-button">店舗管理メニュー</button>
                </form>
            </div>
            @endcan
        </div>

        @yield('header__right')

    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>