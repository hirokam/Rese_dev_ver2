@extends('layouts/base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/shop_all.css') }}">
@endsection

@section('header__right')
    <div class="header__right">
    @if (Auth::user()->role->role === 'admin')
        <nav class="header__right-nav">
            <ul class="header__right-email">
                <a href="/admin/shop_all"><button>店舗一覧</button></a>
                <form action="/admin/send_mail" method="get">
                    <button class="email__button"><li>メールを送る</li></button>
                </form>
            </ul>
        </nav>
    @elseif (Auth::user()->role->role === 'store')
        <nav class="header__right-nav">
            <ul class="header__right-ul">
                <form action="/store-representative/csv-import" method="post"  enctype="multipart/form-data">
                @csrf
                    <input type="file" name="csv">
                    <button>CSVインポート</button>
                </form>
                <form action="/store-representative/reservation" method="get">
                    <button><li>予約状況表示</li></button>
                </form>
            </ul>
        </nav>
        <div class="register__alert">
            <div class="register__alert--success">
                {{ session('message') }}
            </div>
            @if (session('validation_errors'))
            <div class="register__alert--validation">
                <ul>
                    @foreach (session('validation_errors') as $errors)
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    @elseif (Auth::user()->role->role === 'user')
        <form action="/sort" method="post" id="submit_form">
        @csrf
            <select name="sort_by" id="sort_by_select">
                <option value="" disabled selected style='display:none;'>並び替え：評価高/低</option>
                <option value="random">ランダム</option>
                <option value="high_rating">評価が高い順</option>
                <option value="low_rating">評価が低い順</option>
            </select>
        </form>
        <div class="header__right-inner">
            <div class="header__right-search">
                <div class="search-area__space">
                    <form action="/search" class="search-group" method="post">
                    @csrf
                        <select name="area" id="" class="select">
                            <option value="">All area</option>
                            @foreach ($areas as $area)
                                <option>{{ $area->area }}</option>
                            @endforeach
                        </select>
                        <select name="genre" id="" class="select">
                            <option value="">All genre</option>
                            @foreach ($genres as $genre)
                                <option>{{ $genre->genre }}</option>
                            @endforeach
                        </select>
                        <div class="search-button__frame">
                            <input type="text" name="text" class="search" placeholder="Search ...">
                            <button class="search__button">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection

@section('content')
    @if (Auth::user()->role->role === 'admin')
    <div class="admin-register__frame">
        <div class="admin-register__inner-frame">
            <div class="admin-register__header">
                <span class="admin-title">店舗代表者データ登録</span>
            </div>
            <div class="admin-register__inner">
                <form action="/admin/register" method="post">
                @csrf
                    <div class="admin-input-area">
                        <label class="admin-label">氏名：<input type="text" name="name" class="admin-input-name"></label>
                    </div>
                    <div class="admin-input-area">
                        <label class="admin-label">メールアドレス：<input type="email" name="email" class="admin-input-email"></label>
                    </div>
                    <div class="admin-input-area">
                        <label class="admin-label">パスワード：<input type="text" name="password" class="admin-input-password" value="12345678" readonly></label>
                    </div>
                    <div class="admin-button__area">
                        <button class="admin-register-button">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif (Auth::user()->role->role === 'store')
    <div class="store-register__frame">
        <div class="store-register__inner-frame">
            <div class="store-register__header">
                <span class="store-title">店舗データ登録</span>
            </div>
            <div class="store-register__inner">
                <form action="/store-representative/register" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="store-input-area">
                        <label class="store-label-shop">店舗名：<input type="text" name="shop_name" class="store-name"></label>
                    </div>
                    <div class="store-input-area">
                        <label class="store-label-area">エリア：<select name="area" class="store-area">
                            <option value="">選択してください</option>
                            @foreach ($areas as $area)
                            <option value="{{$area->id}}">{{$area->area}}</option>
                            @endforeach
                        </select></label>
                    </div>
                    <div class="store-input-area">
                        <label class="store-label-genre">ジャンル：<select name="genre" class="store-genre">
                            <option value="">選択してください</option>
                            @foreach ($genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->genre}}</option>
                            @endforeach
                        </select></label>
                    </div>
                    <div class="store-input-area">
                        <label class="store-label-overview">概要：<textarea name="overview" class="store-overview"></textarea></label>
                    </div>
                    <div class="store-input-area">
                        <label class="store-label-image">店舗画像：
                            <input type="file" name="image" class="store-image">
                        </label>
                    </div>
                    <div class="store-button__area">
                        <button class="store-register-button">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif (Auth::user()->role->role === 'user')
        @if (session()->has('search_results'))
        <div class="shop-all__frame">
            @foreach (session('search_results') as $shop)
                <div class="shop__frame">
                    <div class="shop-data">
                        <div class="shop-image__frame">
                            @if ($shop->picture_url)
                            <img src="{{ $shop->picture_url }}" alt="店舗イメージ" class="shop-image">
                            @else
                            <img src="{{ asset($shop->file_path) }}" alt="店舗イメージ" class="shop-image">
                            @endif
                        </div>
                        <h2 class="shop-name">{{ $shop->shop_name }}</h2>
                        <div class="shop__area-genre-review">
                            <div class="shop__area-genre">
                                <h3 class="shop-area">#{{ $shop->area->area }}</h3>
                                <h3 class="shop-genre">#{{ $shop->genre->genre }}</h3>
                            </div>
                            <p class="shop-review"><span class="star--blue">★</span>:{{ number_format($shop->average_stars, 1) }}({{ $shop->count_reviews }})</p>
                        </div>
                        @if($shop->is_favorite)
                        <div class="shop__detail-favorite">
                            <form action="/detail/:shop_id={{ $shop->id }}" method="post">
                            @csrf
                                <input type="hidden" value="{{ $shop->id }}">
                                <button class="detail">詳しくみる</button>
                            </form>
                            <form action="/create_favorite" method="post" class="favorite">
                            @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <div class="favorite-hart">
                                    <div class="favorite__active">
                                        <button class="material-symbols-outlined">favorite</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <div class="shop__detail-favorite">
                            <form action="/detail/:shop_id={{ $shop->id }}" method="post">
                            @csrf
                                <input type="hidden" value="{{ $shop->id }}">
                                <button class="detail">詳しくみる</button>
                            </form>
                            <form action="/create_favorite" method="post" class="favorite">
                            @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <div class="favorite-hart">
                                    <div class="favorite__nonactive">
                                        <button class="material-symbols-outlined">favorite</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="shop-all__frame">
            @foreach ($shops as $shop)
                <div class="shop__frame">
                    <div class="shop-data">
                        <div class="shop-image__frame">
                            @if ($shop->picture_url)
                            <img src="{{ $shop->picture_url }}" alt="店舗イメージ" class="shop-image">
                            @else
                            <img src="{{ asset($shop->file_path) }}" alt="店舗イメージ" class="shop-image">
                            @endif
                        </div>
                        <h2 class="shop-name">{{ $shop->shop_name }}</h2>
                        <div class="shop__area-genre-review">
                            <div class="shop__area-genre">
                                <h3 class="shop-area">#{{ $shop->area->area }}</h3>
                                <h3 class="shop-genre">#{{ $shop->genre->genre }}</h3>
                            </div>
                            <p class="shop-review"><span class="star--blue">★</span>:{{ number_format($shop->average_stars, 1) }}({{ $shop->count_reviews }})</p>
                        </div>
                        @if($shop->is_favorite)
                        <div class="shop__detail-favorite">
                            <form action="/detail/:shop_id={{ $shop->id }}" method="post">
                            @csrf
                                <input type="hidden" value="{{ $shop->id }}">
                                <button class="detail">詳しくみる</button>
                            </form>
                            <form action="/create_favorite" method="post" class="favorite">
                            @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <div class="favorite-hart">
                                    <div class="favorite__active">
                                        <button class="material-symbols-outlined">favorite</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <div class="shop__detail-favorite">
                            <form action="/detail/:shop_id={{ $shop->id }}" method="post">
                            @csrf
                                <input type="hidden" value="{{ $shop->id }}">
                                <button class="detail">詳しくみる</button>
                            </form>
                            <form action="/create_favorite" method="post" class="favorite">
                            @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <div class="favorite-hart">
                                    <div class="favorite__nonactive">
                                        <button class="material-symbols-outlined">favorite</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    @endif
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection