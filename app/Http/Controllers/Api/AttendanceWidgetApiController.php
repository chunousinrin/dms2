<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkerV2\AttendanceV2;

class AttendanceWidgetApiController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 今日の勤怠
        |--------------------------------------------------------------------------
        */
        $attendances = AttendanceV2::with(['worker', 'group'])
            ->whereDate('work_date', today())
            ->orderBy('worker_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 集計
        |--------------------------------------------------------------------------
        */
        $totalCount = $attendances->count();

        $workingAttendances = $attendances
            ->whereNull('clock_out')
            ->values();

        $workingCount = $workingAttendances->count();

        /*
        |--------------------------------------------------------------------------
        | JSON返却
        |--------------------------------------------------------------------------
        */
        return response()->json([

            'totalCount' => $totalCount,

            'workingCount' => $workingCount,

            'workers' => $workingAttendances->map(function ($attendance) {

                return [

                    'worker_id' => $attendance->worker_id,

                    'name' => $attendance->worker->name ?? '',

                    'group' => $attendance->group->name ?? '',

                    'clock_in' => optional($attendance->clock_in)
                        ->format('H:i'),

                ];
            }),

            'updated_at' => now()->format('Y-m-d H:i:s'),

        ]);
    }
}
