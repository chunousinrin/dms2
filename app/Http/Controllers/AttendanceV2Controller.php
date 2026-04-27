<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkerV2\WorkerV2;
use App\Models\WorkerV2\AttendanceV2;
use App\Models\WorkerV2\WorkerGroupV2;

class AttendanceV2Controller extends Controller
{
    /**
     * 管理画面
     */
    public function index()
    {
        $attendances = AttendanceV2::with(['worker', 'group'])
            ->where('work_date', today())
            ->get();

        return view('attendance_v2.index', compact('attendances'));
    }

    /**
     * 出勤
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'group_id' => 'required|exists:workergroups_v2,id',
            'comment' => 'nullable|string|max:1000',
        ]);

        $workerId = $request->worker_id;
        $groupId = $request->group_id;
        $today = today();

        // 1日1レコード（なければ作る）
        $attendance = AttendanceV2::firstOrCreate(
            [
                'worker_id' => $workerId,
                'work_date' => $today,
            ],
            [
                'group_id' => $groupId,
                'site_id' => $request->site_id ?? 1,
                'comment' => $request->comment,
            ]
        );

        // 出勤未打刻なら打刻
        if (!$attendance->clock_in) {
            $attendance->clock_in = now();
        }

        // ★ここ重要：毎回更新
        $attendance->group_id = $groupId;
        $attendance->comment = $request->comment;

        $attendance->save();

        return back()->with('success', '出勤打刻しました');
    }

    /**
     * 退勤
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'group_id' => 'required|exists:workergroups_v2,id',
            'comment' => 'nullable|string|max:1000',
        ]);

        $attendance = AttendanceV2::where('worker_id', $request->worker_id)
            ->where('work_date', today())
            ->firstOrFail();

        if ($attendance->clock_in && !$attendance->clock_out) {
            $attendance->clock_out = now();
        }

        // ★退勤時も更新可能
        $attendance->group_id = $request->group_id;
        $attendance->comment = $request->comment;

        $attendance->save();

        return back()->with('success', '退勤打刻しました');
    }

    /**
     * 打刻画面
     */
    public function create($token)
    {
        $worker = WorkerV2::where('qr_token', $token)->firstOrFail();

        $today = today();

        // 今日の勤怠
        $attendance = AttendanceV2::where('worker_id', $worker->id)
            ->where('work_date', $today)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | ① この作業員の現在の班（デフォルト）
        |--------------------------------------------------------------------------
        */
        $defaultGroupId = \DB::table('worker_group_histories')
            ->where('worker_id', $worker->id)
            ->where('start_date', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->value('group_id');

        /*
        |--------------------------------------------------------------------------
        | ② 今日有効な班一覧
        |--------------------------------------------------------------------------
        */
        $activeGroupIds = \DB::table('worker_group_histories')
            ->where('start_date', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->pluck('group_id')
            ->unique();

        /*
        |--------------------------------------------------------------------------
        | ③ 自分の班を補完
        |--------------------------------------------------------------------------
        */
        if ($defaultGroupId) {
            $activeGroupIds->push($defaultGroupId);
        }

        /*
        |--------------------------------------------------------------------------
        | ④ 班取得
        |--------------------------------------------------------------------------
        */
        $groups = WorkerGroupV2::whereIn('id', $activeGroupIds)
            ->orderBy('name')
            ->get();

        return view('attendance_v2.create', compact(
            'worker',
            'attendance',
            'groups',
            'defaultGroupId'
        ));
    }
    public function updateComment(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'comment' => 'nullable|string|max:1000',
        ]);

        $attendance = AttendanceV2::firstOrCreate(
            [
                'worker_id' => $request->worker_id,
                'work_date' => today(),
            ]
        );

        $attendance->comment = $request->comment;
        $attendance->save();

        return back()->with('success', 'コメント保存しました');
    }
}
