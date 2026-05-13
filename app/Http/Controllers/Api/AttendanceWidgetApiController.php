<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkerV2\WorkerV2;
use Illuminate\Http\JsonResponse;

class AttendanceWidgetApiController extends Controller
{
    /**
     * 勤怠ウィジェット用データの取得
     */
    public function index(): JsonResponse
    {
        $today = today();

        // 作業員一覧と本日の勤怠をEager Load
        $workers = WorkerV2::with([
            'todayAttendance' => fn($q) => $q->whereDate('work_date', $today),
            'todayAttendance.group'
        ])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        // 状態別のコレクション分離
        $workingWorkers = $workers->filter(fn($w) => $w->todayAttendance && !$w->todayAttendance->clock_out);
        $missingWorkers = $workers->whereNull('todayAttendance');

        return response()->json([
            'totalCount'   => $workers->count(),
            'workingCount' => $workingWorkers->count(),
            'missingCount' => $missingWorkers->count(),
            'workers'      => $workingWorkers->map(fn($worker) => [
                'worker_id' => $worker->id,
                'name'      => $worker->name,
                'group'     => $worker->todayAttendance->group->name ?? '',
                'clock_in'  => $worker->todayAttendance->clock_in?->format('H:i'),
                'status'    => 'working',
            ]),
            'updated_at'   => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
