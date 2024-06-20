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

@section('content')
<main>
  <div class="stamp">
  @if(Auth::check())
    <h2 class="stamp-title">{{ Auth::user()->name }}さんの勤務状況</h2>
  @endif
  @foreach($dates as $date)
    @if($date->attendances)
      <h3><a href="{{ route('attendance.show', ['date' => $date->date]) }}">{{ $date->date }}</a></h3>  
        <table class="attendance-date">
          <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
          </tr>
  @foreach($date->attendances as $attendance)
          <tr>
            <td>{{ $attendance->user->name }}</td>
            <td>{{ $attendance->clock_in }}</td>
            <td>{{ $attendance->clock_out }}</td>
            <td>
           @foreach($attendance->breaktimes as $break)
                {{ $break->break_start }} - {{ $break->break_end }}<br>
            @endforeach</td>
            <td>{{ $attendance->work_time }}</td>
          </tr>
          @endforeach
        </table>
        @else
        <p>{{ $date->date }} の勤務記録がありません。</p>
      @endif
    @endforeach
  @endif
  </div>
</main>
@endsection
        