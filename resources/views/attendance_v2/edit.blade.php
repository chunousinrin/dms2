@extends('adminlte::master')

@section('title', '勤怠修正')

@section('content')

<div class="card">

    <div class="card-header">
        勤怠修正
    </div>

    <form
        method="POST"
        action="{{ route('attendance_v2.update', $attendance->id) }}">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>作業員</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $attendance->worker->name }}"
                    readonly>
            </div>

            <div class="form-group">
                <label>班</label>

                <select
                    name="group_id"
                    class="form-control">

                    @foreach($groups as $group)

                    <option
                        value="{{ $group->id }}"
                        {{ $attendance->group_id == $group->id ? 'selected' : '' }}>

                        {{ $group->name }}

                    </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>出勤</label>

                <input
                    type="time"
                    name="clock_in"
                    class="form-control"
                    value="{{ optional($attendance->clock_in)->format('H:i') }}">
            </div>

            <div class="form-group">
                <label>退勤</label>

                <input
                    type="time"
                    name="clock_out"
                    class="form-control"
                    value="{{ optional($attendance->clock_out)->format('H:i') }}">
            </div>

            <div class="form-group">
                <label>コメント</label>

                <textarea
                    name="comment"
                    class="form-control"
                    rows="3">{{ $attendance->comment }}</textarea>
            </div>

        </div>

        <div class="card-footer text-right">

            <button
                class="btn btn-primary">

                保存

            </button>

        </div>

    </form>

</div>

@endsection