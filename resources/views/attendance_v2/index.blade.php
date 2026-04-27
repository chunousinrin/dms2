@extends('adminlte::page')

@section('title', '勤怠一覧')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">本日の勤怠一覧</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>氏名</th>
                <th>班</th>
                <th>出勤</th>
                <th>退勤</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->worker->name }}</td>
                <td>{{ $attendance->group->name ?? '-' }}</td>
                <td>
                    {{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '--' }}
                </td>
                <td>
                    {{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '--' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection