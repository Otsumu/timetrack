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
  <form class="date__wrap" action="{{ route('attendance.perDate') }}" method="post">
    @csrf
    <button class="date-button" name="prevDate"><</button>
   
      <input type="hidden" name="displayDate" value="{{ $displayDate->toDateString() }}">
      <p class="date-text">{{ $displayDate->format('Y-m-d') }}</p>
  
    <button class="date-button" name="nextDate">></button>
  </form>
  <div class="stamp">
    <table class="attendance__table">
      <tr class="table__row">
        <th class="table__header" style="font-weight: bold;">名前</th>
        <th class="table__header" style="font-weight: bold;">勤務開始</th>
        <th class="table__header" style="font-weight: bold;">勤務終了</th>
        <th class="table__header" style="font-weight: bold;">休憩開始</th>
        <th class="table__header" style="font-weight: bold;">休憩終了</th>
      </tr>
        @foreach($attendances as $attendance)
          @php
            $registereduser = $attendance->registeredUser;
            $breaktime = $attendance->breaktimes->first(); 
          @endphp
          <tr class="table__row">  
            <td>{{ $registereduser->name ?? 'N/A' }}</td>
            <td class="table__header">{{ $attendance->clock_in }}</td>
            <td class="table__header">{{ $attendance->clock_out }}</td>
            <td class="table__data">{{ $breaktime->break_start ?? 'N/A' }}</td>
            <td class="table__data">{{ $breaktime->break_end ?? 'N/A' }}</td>
          </tr>
        @endforeach  
    </table>
    {{ $attendances->links('vendor/pagination/paginate') }}
  </div>  
</main>
@endsection
