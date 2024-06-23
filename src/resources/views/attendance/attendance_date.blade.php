@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header_inner-right')
<div class="header-right">
    <ul class="nav-menu">
      @if(Auth::check())
        <li><a href="/">ホーム</a></li>
        <li><a href="">日付一覧</a></li>
        <li>
          <form action="{{ route('logout') }}" method="post" style="display: inline;">
            @csrf
            <button type="submit" class="nav-menu__link">ログアウト</button>
          </form>
        </li>  
      @endif
    </ul>
</div>
@endsection

@section('content')
<main>
  @if(Auth::check())
    <h2 class="stamp-title">{{Auth::user()->name}}さんの勤務状況</h2>
  <div class= "stamp">
    @endif
    <table class= "attendance__table">
      <tr class= "table__row">
        <th class= "table__header" style="font-weight: bold;">名前</th>
        <th class= "table__header" style="font-weight: bold;">勤務開始</th>
        <th class= "table__header" style="font-weight: bold;">勤務終了</th>
        <th class= "table__header" style="font-weight: bold;">休憩時間</th>
        <th class= "table__header" style="font-weight: bold;">勤務時間</th>
      </tr>
    @foreach($attendances as $attendance)
        @php
        $registereduser = $attendance->registeredUser;
        @endphp
      <tr class= "table__row">  
        <th>{{ $registereduser->name ?? 'N/A' }}</th>
        <th class= "table__header">{{ $attendance->clock_in }}</th>
        <th class= "table__header">{{ $attendance->clock_out }}</th>
        <th class= "table__header">{{ $attendance->break_start }}</th>
        <th class= "table__header">{{ $attendance->break_end }}</th>
      </tr>
    @endforeach  
    </table>
    {{ $attendances ->links() }}
  </div>  
@endsection