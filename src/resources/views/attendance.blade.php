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
          <form action="/logout" method="post">
          @csrf
          <button class="nav-menu__link" href="/logout">ログアウト</button>
          </form>
        </li>  
      @endif
    </ul>
</div>
@endsection

@section('content')
@foreach($attendancesByDate['attendance_date'] as $attendanceDate)
<table class="attendance-date">
  <caption><h3>{{ $attendanceDate['date'] }}</h3></caption>
    <tr>
      <th>名前</th>
      <th>勤務開始</th>
      <th>勤務終了</th>
      <th>休憩時間</th>
      <th>勤務時間</th>
    </tr>
    @foreach($attendanceDate['attendances'] as $attendance)
    <tr>
      <td>{{ $attendance->name }}</td>
      <td>{{ $attendance->clock_in }}</td>
      <td>{{ $attendance->clock_end }}</td>
      <td>{{ $attendance->break_start }}</td>
      <td>{{ $attendance->work_hours }}</td>
    </tr>
    @endforeach
  </table>
@endforeach
@endsection

