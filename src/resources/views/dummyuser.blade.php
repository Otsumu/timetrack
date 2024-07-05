@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/dummyuser.css') }}">
@endsection

@section('content')
<main>
    <h2>{{ $registeredUser->name }}さんの勤怠表</h2>
    @if($attendances->count())
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
            $registereduser = $attendance->registeredUser;
            $breaktime = $attendance->breaktimes->first(); 
          @endphp
          <tr class="table__row">  
            <td>{{ $attendance->date }}</td>
            <td class="table__header">{{ $attendance->clock_in }}</td>
            <td class="table__header">{{ $attendance->clock_out }}</td>
            <td class="table__data">{{ $breaktime->break_start ?? 'N/A' }}</td>
            <td class="table__data">{{ $breaktime->break_end ?? 'N/A' }}</td>
          </tr>
          @endforeach  
        </tbody>
    </table>
    {{ $attendances->appends(['displayDate' => $displayDate])->links('vendor/pagination/paginate') }}
    @else
    <p>勤怠データがありません。</p>
    @endif
</main>
@endsection
