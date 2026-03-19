@extends('adminlte::page')

@section('title', 'LINE WORKS 勤怠一覧')

@section('content_header')
<h1>LINE WORKS 勤怠管理 ({{ $month }})</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">打刻ログ</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>ユーザーID</th>
                    <th>区分</th>
                    <th>係数</th>
                    <th>記録日時</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $item)
                <tr>
                    <td>{{ $item->work_date->format('Y/m/d') }}</td>
                    <td>{{ $item->line_works_id }}</td>
                    <td>
                        <span class="badge {{ $item->value >= 1.0 ? 'badge-success' : 'badge-warning' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ number_format($item->value, 1) }}</td>
                    <td>{{ $item->created_at->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop