<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <div class="grid__parent">
        <header class="header-group">
            <div class="header__menu">
                <form action="/menu" method="get">
                    <button class="menu__button">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </form>
            </div>
            <div class="app-title__space">
                <span class="app-title">Rese</span>
            </div>
        </header>
        <div class="shop-detail">
            <div class="shop-name__group">
                <div class="return">
                    <a href="/">
                        <button class="return__button">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                    </a>
                </div>
                <div class="shop-name__frame">
                    <h2 class="shop-name">{{ $shop_detail->shop_name }}</h2>
                </div>
            </div>
            <img src="{{$shop_detail->picture_url}}" alt="店舗イメージ" class="shop-image" >
            <div class="shop__area-genre">
                <h3 class="shop-area">#{{ $shop_detail->area }}</h3>
                <h3 class="shop-genre">#{{ $shop_detail->genre }}</h3>
            </div>
            <p class="over-view">{{ $shop_detail->overview }}</p>
        </div>
        <div class="reservation-group">
            <div class="reservation__frame">
                <h2 class="reservation-header">予約</h2>
                <form action="/reservation" method="post">
                @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop_id }}">
                    <div class="date__frame">
                        <input type="date" name="reservation_date" class="input_date" value="input">
                    </div>
                    <div class="time__frame">
                        <input type="time" name="reservation_time" class="input_time">
                    </div>
                    <div class="people__frame">
                        <input type="number" name="reservation_number" class="input_people">
                    </div>
                    <div class="reservation-info__frame"></div>
                    <div class="info__inner">
                        <div class="shop-info">
                            <h4 class="info__header">Shop</h4>
                            <span class="shop">{{ $shop_detail->shop_name }}</span>
                        </div>
                        <div class="date-info">
                            <h4 class="info__header">Date</h4>
                            <span class="date">@error('reservation_date')<span class="validation">{{ $errors->first('reservation_date') }}</span>@enderror</span>
                        </div>
                        <div class="time-info">
                            <h4 class="info__header">Time</h4>
                            <span class="time">@error('reservation_time')<span class="validation">{{ $errors->first('reservation_time') }}</span>@enderror</span>
                        </div>
                        <div class="number-info">
                            <h4 class="info__header">Number</h4>
                            <span class="number">@error('reservation_number')<span class="validation">{{ $errors->first('reservation_number') }}</span>@enderror</span>
                        </div>
                    </div>
                    <div class="reservation-button__frame">
                        <button class="reservation__button">予約する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inputDate = document.querySelector('.input_date');
        const inputTime = document.querySelector('.input_time');
        const inputPeople = document.querySelector('.input_people');
        const dateOutput = document.querySelector('.date');
        const timeOutput = document.querySelector('.time');
        const numberOutput = document.querySelector('.number');

        inputDate.addEventListener('input', () => {
            dateOutput.textContent = inputDate.value;
        });

        inputTime.addEventListener('input', () => {
            timeOutput.textContent = inputTime.value;
        });

        inputPeople.addEventListener('input', () => {
            numberOutput.textContent = inputPeople.value;
        });
    </script>
</body>
</html>
