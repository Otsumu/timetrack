@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
  <link rel="stylesheet" href="{{ asset('css/attendance_user.css') }}">
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
<form class="user__wrap" action="{{ route('attendance_user') }}" method="post">
  @csrf
    @if($displayUser !=null)
      <p class="user__text">{{ $displayUser }}さんの勤怠表</p>
    @else 
      <p class="user__text">ユーザーを選択して下さい</p>
    @endif

    <div class="search__item">
        <input class="search__input" type="text" name="search__name" placeholder="名前検索" value="{{ $searchparam['name'] ?? ''}}" list="user_list">
        <datalist id= "user_list">
            @if($userList)
              @foreach($userList as $user)
              <option value="{{ $user->name }}">{{ $user->name }}</option>
              @endforeach
            @endif
        </datalist>
        <button class="search__button">検索</button>
    </div>
</form>          

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
    {{ $attendances->appends(['displayDate' => $displayDate])->links('vendor/pagination/paginate') }}


  </div>
</main>
@endsection