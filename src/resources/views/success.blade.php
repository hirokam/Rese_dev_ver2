@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="content__frame">
        <div class="message-space">
            <span class="message">登録が完了しました</span>
        </div>
        <div class="button-space">
            <a href="/"><button class="button">戻る</button></a>
        </div>
    </div>
@endsection