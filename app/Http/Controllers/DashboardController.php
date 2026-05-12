<?php

namespace App\Http\Controllers;

use App\Models\WorkerV2\AttendanceV2;

class DashboardController extends Controller
{

    /**
     * Dashboard
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 今日の勤怠
        |--------------------------------------------------------------------------
        */
        $todayAttendances = AttendanceV2::with(['worker', 'group'])
            ->whereDate('work_date', today())
            ->orderBy('worker_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 集計
        |--------------------------------------------------------------------------
        */
        $totalCount = $todayAttendances->count();

        $workingCount = $todayAttendances
            ->whereNull('clock_out')
            ->count();

        $completedCount = $todayAttendances
            ->whereNotNull('clock_out')
            ->count();

        $commentCount = $todayAttendances
            ->filter(function ($attendance) {

                return !empty(trim($attendance->comment ?? ''));
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 未退勤一覧
        |--------------------------------------------------------------------------
        */
        $workingAttendances = $todayAttendances
            ->whereNull('clock_out');

        /*
        |--------------------------------------------------------------------------
        | コメント有一覧
        |--------------------------------------------------------------------------
        */
        $commentAttendances = $todayAttendances
            ->filter(function ($attendance) {

                return !empty(trim($attendance->comment ?? ''));
            });

        return view('dashboard', compact(
            'todayAttendances',
            'totalCount',
            'workingCount',
            'completedCount',
            'commentCount',
            'workingAttendances',
            'commentAttendances'
        ));
    }
}
