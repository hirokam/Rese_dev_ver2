<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <div class="header__all">
            <div class="header__menu-title">
                <form action="/menu" method="get">
                    <button class="menu__button">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </form>
                <div class="app-title__space">
                    <span class="app-title">Rese</span>
                </div>
            </div>

            @yield('header__right')
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>