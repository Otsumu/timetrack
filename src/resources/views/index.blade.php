@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header_inner-right')
<div class="header-right">
    <ul class="nav-menu">
      @if(Auth::check())
        <li><a href="/">ホーム</a></li>
        <li><a href="">日付一覧</a></li>
        <li>
          <form action="/" method="post">
          @csrf
          <a class="nav-menu__link" href="/">ログアウト</a>
          </form>
        </li>  
     @endif
    </ul>
</div>
@endsection

@section('content')
<main>
  <div class="stamp">
  <h2 class="stamp-title">{{ Auth::user()->name }}さんお疲れ様です！</h2>
  <div class="stamp-category">
    <p class="clock_in">勤務開始</p>
    <p class="clock_out">勤務終了</p>
    <p class="break_start">休憩開始</p>
    <p class="break_end">休憩終了</p>
</div>
</main>
@endsection