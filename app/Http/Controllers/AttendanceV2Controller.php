<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkerV2\WorkerV2;
use App\Models\WorkerV2\AttendanceV2;
use App\Models\WorkerV2\WorkerGroupV2;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceV2Controller extends Controller
{
    /**
     * 管理画面
     */
    public function index(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | 日付（デフォルト今日）
    |--------------------------------------------------------------------------
    */
        $workDate = $request->work_date ?? today()->toDateString();

        /*
    |--------------------------------------------------------------------------
    | 一覧Query
    |--------------------------------------------------------------------------
    */
        $query = AttendanceV2::with(['worker', 'group'])
            ->whereDate('work_date', $workDate);

        /*
    |--------------------------------------------------------------------------
    | 作業員絞り込み
    |--------------------------------------------------------------------------
    */
        if ($request->filled('worker_id')) {

            $query->where('worker_id', $request->worker_id);
        }

        /*
    |--------------------------------------------------------------------------
    | 未退勤のみ
    |--------------------------------------------------------------------------
    */
        if ($request->filled('only_working')) {

            $query->whereNull('clock_out');
        }

        /*
    |--------------------------------------------------------------------------
    | 一覧取得
    |--------------------------------------------------------------------------
    */
        $attendances = $query
            ->orderBy('worker_id')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | 集計
    |--------------------------------------------------------------------------
    */

        $workers = WorkerV2::with([
            'todayAttendance',
            'todayAttendance.group'
        ])
            ->orderBy('id')
            ->get();

        $totalCount = $workers->count();

        $workingCount = $attendances
            ->whereNull('clock_out')
            ->count();

        $completedCount = $attendances
            ->whereNotNull('clock_out')
            ->count();

        $missingCount = $workers
            ->whereNull('todayAttendance')
            ->count();

        $workingCount = $workers
            ->filter(function ($worker) {

                return $worker->todayAttendance
                    && !$worker->todayAttendance->clock_out;
            })
            ->count();

        /*
    |--------------------------------------------------------------------------
    | 指定日で有効な作業員一覧
    |--------------------------------------------------------------------------
    */
        $workers = WorkerV2::where('is_active', true)

            ->whereHas('groupHistories', function ($q) use ($workDate) {

                $q->where('start_date', '<=', $workDate)
                    ->where(function ($q2) use ($workDate) {

                        $q2->whereNull('end_date')
                            ->orWhere('end_date', '>=', $workDate);
                    });
            })

            ->orderBy('id')

            ->get();

        /*
    |--------------------------------------------------------------------------
    | 指定日の打刻済 worker_id
    |--------------------------------------------------------------------------
    */
        $attendanceWorkerIds = AttendanceV2::whereDate(
            'work_date',
            $workDate
        )->pluck('worker_id');

        /*
    |--------------------------------------------------------------------------
    | 未打刻者
    |--------------------------------------------------------------------------
    */
        $missingWorkers = WorkerV2::where('is_active', true)

            ->whereHas('groupHistories', function ($q) use ($workDate) {

                $q->where('start_date', '<=', $workDate)
                    ->where(function ($q2) use ($workDate) {

                        $q2->whereNull('end_date')
                            ->orWhere('end_date', '>=', $workDate);
                    });
            })

            ->whereNotIn('id', $attendanceWorkerIds)

            ->orderBy('id')

            ->get();

        /*
    |--------------------------------------------------------------------------
    | view
    |--------------------------------------------------------------------------
    */
        return view('attendance_v2.index', compact(
            'attendances',
            'workers',
            'workDate',
            'totalCount',
            'workingCount',
            'completedCount',
            'missingWorkers'
        ));
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
    public function exportCsv(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | 対象月
    |--------------------------------------------------------------------------
    */
        $targetMonth = $request->target_month;

        /*
    |--------------------------------------------------------------------------
    | 未指定なら今月
    |--------------------------------------------------------------------------
    */
        if (!$targetMonth) {

            $targetMonth = now()->format('Y-m');
        }

        /*
    |--------------------------------------------------------------------------
    | 月初・月末
    |--------------------------------------------------------------------------
    */
        $startDate = Carbon::parse($targetMonth . '-01')->startOfMonth();

        $endDate = Carbon::parse($targetMonth . '-01')->endOfMonth();

        /*
    |--------------------------------------------------------------------------
    | データ取得
    |--------------------------------------------------------------------------
    */
        $attendances = AttendanceV2::with(['worker', 'group'])
            ->whereBetween('work_date', [$startDate, $endDate])
            ->orderBy('work_date')
            ->orderBy('worker_id')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | ファイル名
    |--------------------------------------------------------------------------
    */
        $fileName = $targetMonth . '_attendance.csv';

        /*
    |--------------------------------------------------------------------------
    | CSVレスポンス
    |--------------------------------------------------------------------------
    */
        $response = new StreamedResponse(function () use ($attendances) {

            $handle = fopen('php://output', 'w');

            /*
        |--------------------------------------------------------------------------
        | Excel文字化け対策（重要）
        |--------------------------------------------------------------------------
        */
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /*
        |--------------------------------------------------------------------------
        | ヘッダー
        |--------------------------------------------------------------------------
        */
            fputcsv($handle, [
                '日付',
                '作業員ID',
                '氏名',
                '班ID',
                '班名',
                '出勤',
                '退勤',
                'コメント',
            ]);

            /*
        |--------------------------------------------------------------------------
        | データ
        |--------------------------------------------------------------------------
        */
            foreach ($attendances as $attendance) {

                fputcsv($handle, [

                    optional($attendance->work_date)->format('Y-m-d'),

                    $attendance->worker_id,

                    $attendance->worker->name ?? '',

                    $attendance->group_id,

                    $attendance->group->name ?? '',

                    optional($attendance->clock_in)->format('H:i'),

                    optional($attendance->clock_out)->format('H:i'),

                    $attendance->comment,

                ]);
            }

            fclose($handle);
        });

        /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */
        $response->headers->set(
            'Content-Type',
            'text/csv; charset=UTF-8'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="' . $fileName . '"'
        );

        return $response;
    }
}
