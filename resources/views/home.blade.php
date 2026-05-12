@extends('adminlte::page')
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="css/dms_home.css">
<style>
    .ui-datepicker {
        z-index: 1000 !important;
    }
</style>
@stop

@section('content_header')

@stop

@section('content')
<div class="row">

    <div class="col-12 col-md-9">
        <div class="row no-gutters">
            @include('home.button')
        </div>
        <hr>
        <div class="row no-gutters">
            @include('home.license')
        </div>
        <hr>
        <div class="row no-gutters">
            @include('home.release')
        </div>
    </div>

    <div class="col-12 col-md-3 d-none d-md-block">

        <div class="card" style="background-color: lightseagreen;color:white;font-weight:extra-bold;">
            <div class="card-body text-center">
                <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem;">{{ now()->format('F')}}</div>
                <div class="card-text" style="font-size: 7rem;line-height:7rem;">{{ now()->format('d')}}</div>
                <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem">{{ now()->format('l') }}</div>
            </div>
        </div>

        <div class="row no-gutters">




            <div class="col-12 col-md-3 d-none d-md-block">

                <div class="card" style="background-color: lightseagreen;color:white;font-weight:extra-bold;">
                    <div class="card-body text-center small-box mb-0">
                        <div class="inner">
                            <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem;">{{ now()->format('F')}}</div>
                            <div class="card-text" style="font-size: 7rem;line-height:7rem;">{{ now()->format('d')}}</div>
                            <div class="card-text" style="font-size: 1.5rem;line-height:1.5rem">{{ now()->format('l') }}</div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>

                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>

                <div class="card bg-info text-white">
                    <div class="card-header d-flex align-items-center">
                        <span>作業員出勤状況</span>
                        <a href="{{ route('attendance_v2.index') }}" class="ml-auto text-white">
                            <i class="fas fa-external-link-square-alt"></i>
                        </a>
                    </div>

                    <div class="card-body position-relative">
                        {{-- 背景アイコン --}}
                        <div class="position-absolute" style="right:20px; top:10px; opacity:0.15; font-size:70px;">
                            <i class="fas fa-users"></i>
                        </div>

                        <div class="d-flex border-bottom py-1">
                            <span>出勤人数</span>
                            <h4 class="ml-auto mb-0">{{ $totalCount }}</h4>
                        </div>

                        <div class="d-flex py-1">
                            <span>未退勤</span>
                            <h4 class="ml-auto mb-0">{{ $workingCount }}</h4>
                        </div>
                    </div>

                    <div class="card-footer p-0">
                        <details>
                            <summary class="px-4 py-3">未退勤者一覧</summary>
                            <div style="max-height:250px; overflow:auto;">
                                <table class="table table-sm bg-white mb-0">
                                    <thead>
                                        <tr>
                                            <th class="pl-2">氏名</th>
                                            <th class="text-center">出勤時刻</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($workingAttendances as $attendance)
                                        <tr>
                                            <td class="pl-2">
                                                {{ $attendance->worker->name ?? '' }}
                                            </td>
                                            <td class="text-center">
                                                {{ optional($attendance->clock_in)->format('H:i') }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">全員退勤済です</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    </div>
                </div>
            </div>

        </div>

        <div class="row no-gutters">
            @include('home.worker_attendance_check')
        </div>
        <div class="row no-gutters">
            @include('home.minical')
        </div>
        <div class="row no-gutters">
            @include('home.topic')
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css">
<script src="/js/document_manage.js"></script>
@endsection