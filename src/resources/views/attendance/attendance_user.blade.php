@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header_inner-right')
<div class="header-right">
    <ul class="nav-menu">
      @if(Auth::check())
        <li><a href="/">ホーム</a></li>
        <li><a href="{{ route('date.list') }}">日付一覧</a></li>
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
  <div class="stamp">
    @if(Auth::check())
      <h2 class="stamp-title">{{ Auth::user()->name }}さんの勤務状況</h2>
    @endif

    @foreach($attendances as $attendance)
      <table class="attendance-user">
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        <tr>
          <td>{{ $attendance->name }}</td>
          <td>{{ $attendance->clock_in }}</td>
          <td>{{ $attendance->clock_end }}</td>
          <td>{{ $attendance->break_start }}</td>
          <td>{{ $attendance->work_hours }}</td>
        </tr>
      </table>
    @endforeach
  </div>
</main>
@endsection