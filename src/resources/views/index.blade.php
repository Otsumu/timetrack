@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header_inner-right')
<div class="header-right">
    <ul class="nav-menu">
      @if(Auth::check())
        <li><a href="/">ホーム</a></li>
        <li><a href="{{ route('attendance_date') }}">日付一覧</a></li>
        <li><a href="{{ route('attendance_user') }}">ユーザー一覧</a></li>
        <li><a href="{{ route('attendance.dateList') }}">勤怠表</a></li>
        <li>
          <form action="{{ route('logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="nav-menu__link">
              ログアウト
            </button>
          </form>
        </li>  
      @endif
    </ul>
</div>
@endsection

@section('content')
<main>
  @if(Auth::check())
  <h2 class="stamp-title">{{ Auth::user()->name }}さんお疲れ様です！</h2>
  @endif
  @if(session('message'))
  <div class="alert alert-success">
    {{ session('message') }}
  </div>
  @endif
  <div class="stamp">
  <form class="index-form" action={{ route('attendance') }} method="post">
    @csrf
    <div class="stamp-category">
      @if($status == 0)
        <button name="clock_in" type="submit">勤務開始</button>
      @else
        <button name="clock_in" disabled type="submit">勤務開始</button>
      @endif
    </div>
    <div class="stamp-category">
      @if($status == 1)  
        <button name="clock_out" type="submit">勤務終了</button>
      @else
        <button name="clock_out" disabled type="submit">勤務終了</button>
      @endif
    </div>
    <div class="stamp-category">
      @if($status == 1)
        <button name="break_start" type="submit">休憩開始</button>
      @else
        <button name="break_start" disabled type="submit">休憩開始</button>
      @endif
    </div>
    <div class="stamp-category">
      @if($status == 2)  
        <button name="break_end" type="submit">休憩終了</button>
      @else
        <button name="break_end" disabled type="submit">休憩終了</button>
      @endif
    </div>
  </form> 
  </div>
</main>
@endsection