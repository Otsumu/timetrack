@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('header_inner-right')
<div class="header-right">
    <ul class="nav-menu">
      @if(Auth::check())
        <li><a href="/">ホーム</a></li>
        <li><a href="{{ route('attendance.dateList') }}">日付一覧</a></li>
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
      <h2 class="stamp-title">{{ Auth::user()->name }}さんの勤怠表</h2>
    @endif
  
    <div class="date-list">
      <table class="attendance__table">
          <thead>
            <tr class="table__row">
              <th class="table__header">日付</th>
              <th class="table__header">勤務開始</th>
              <th class="table__header">勤務終了</th>
              <th class="table__header">休憩開始</th>
              <th class="table__header">休憩終了</th>
            </tr>
          </thead>
          <tbody>
            @foreach($attendances as $attendance)
              @php
                $breaktime = $attendance->breaktimes->first(); 
              @endphp
              <tr class="table__row">
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->clock_in ?? 'N/A' }}</td>
                <td>{{ $attendance->clock_out ?? 'N/A' }}</td>
                <td>{{ optional($breaktime)->break_start ?? 'N/A' }}</td>
                <td>{{ optional($breaktime)->break_end ?? 'N/A' }}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
      {{ $attendances->links() }}
    </div>
</main>
@endsection

