@extends('adminlte::master')


@section('title', '勤怠管理')

@section('content_header')
<h2 class="pl-2 m-0">勤怠管理</h2>
@endsection

@section('body')
<div class="container-fluid">

    {{-- タブカード --}}
    <div class="card search-card mb-3">
        <div class="card-header p-0">
            <ul class="nav nav-tabs nav-justified" id="attendance-tab" role="tablist">
                {{-- 検索 --}}
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold rounded-0" id="search-tab" data-toggle="pill" href="#search-area" role="tab">
                        <i class="fas fa-search"></i>&nbsp;検索
                    </a>
                </li>
                {{-- CSV --}}
                <li class="nav-item">
                    <a class="nav-link font-weight-bold rounded-0" id="csv-tab" data-toggle="pill" href="#csv-area" role="tab">
                        <i class="fas fa-file-csv"></i>&nbsp;CSV出力
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                {{-- ===================================================== --}}
                {{-- 検索タブ --}}
                {{-- ===================================================== --}}
                <div class="tab-pane fade show active" id="search-area" role="tabpanel">
                    <form method="GET" action="{{ route('attendance_v2.index') }}">
                        <div class="form-row align-items-center mb-2">
                            {{-- 日付 --}}
                            <div class="col-5">
                                <label class="field-label">日付</label>
                                <input type="input" name="work_date" class="form-control datepicker" value="{{ request('work_date', $workDate) }}">
                            </div>
                            <div class="col-5">
                                {{-- 作業員 --}}
                                <label class="field-label">作業員</label>
                                <select name="worker_id" class="form-control">
                                    <option value="">すべて</option>
                                    @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}" {{ request('worker_id') == $worker->id ? 'selected' : '' }}>
                                        {{ $worker->id }} : {{ $worker->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- 未退勤 --}}
                            <div class="col-auto ml-auto">
                                <label class="field-label">&nbsp;</label>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="only_working" value="1" {{ request('only_working') ? 'checked' : '' }}>
                                    <label class="form-check-label">未退勤のみ</label>
                                </div>
                            </div>
                        </div>
                        {{-- 検索 --}}
                        <div class="action-bar d-flex justify-content-between align-items-center">
                            <a href="{{ route('attendance_v2.index') }}" class="btn-reset">
                                <i class="fas fa-undo mr-1"></i> 条件をリセット
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary px-4 shadow-sm">
                                <i class="fas fa-search mr-2"></i> この条件で絞り込む
                            </button>
                        </div>
                    </form>
                </div>
                {{-- ===================================================== --}}
                {{-- CSVタブ --}}
                {{-- ===================================================== --}}
                <div class="tab-pane fade" id="csv-area" role="tabpanel">
                    <form method="GET" action="{{ route('attendance_v2.exportCsv') }}">
                        <div class="form-row">
                            {{-- 対象月 --}}
                            <div class="col-auto">
                                <label class="field-label">対象月</label>
                            </div>
                            <div class="col-2">
                                <input type="month" name="target_month" class="form-control" value="{{ now()->format('Y-m') }}">
                            </div>

                            {{-- CSV出力 --}}
                            <div class="col-2 ml-auto">
                                <button class="btn btn-sm btn-success btn-block"><i class="fas fa-file-csv"></i>&nbsp;CSV出力</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 集計 --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="small-box bg-info mb-0">
                <div class="inner">
                    <p>総人数</p>
                    <h3 class="text-center">{{ $totalCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-success mb-0">
                <div class="inner">
                    <p>退勤済</p>
                    <h3 class="text-center">{{ $completedCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-warning mb-0">
                <div class="inner">
                    <p>未退勤</p>
                    <h3 class="text-center">{{ $workingCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- 一覧 --}}
    <div class="card search-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
            <h5 class="m-0 h6 font-weight-bold text-success">
                <i class="fas fa-list-ul mr-1"></i> 勤怠一覧
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive-custom" style="max-height: 100%;">
                <table class="table table-sm table-custom">
                    <thead>
                        <tr>
                            <th style="width: 150px;">日付</th>
                            <th style="width: 150px;">氏名</th>
                            <th style="width: 150px;">所属</th>
                            <th style="width: 150px;">出勤</th>
                            <th style="width: 150px;">退勤</th>
                            <th>コメント</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->work_date->format('Y-m-d') }}</td>
                            <td>{{ $attendance->worker->name ?? '' }}</td>
                            <td>{{ $attendance->group->name ?? '' }}</td>
                            <td>{{ optional($attendance->clock_in)->format('H:i') }}</td>
                            <td>{{ optional($attendance->clock_out)->format('H:i') }}</td>
                            <td>{{ $attendance->comment }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">データがありません</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
@vite('resources/css/custom.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@vite('resources/css/components/index-design.css')
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
@vite(['resources/js/components/datepicker.js'])
@vite(['resources/js/components/fancybox.js'])
@endsection