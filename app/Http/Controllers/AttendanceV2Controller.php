<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkerV2\WorkerV2;
use App\Models\WorkerV2\AttendanceV2;
use App\Models\WorkerV2\WorkerGroupV2;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

class AttendanceV2Controller extends Controller
{
    /**
     * 管理画面
     */
    public function index(Request $request)
    {
        $workDate = $request->work_date ?? today()->toDateString();

        // 作業員一覧のクエリ構築
        $query = WorkerV2::with([
            'todayAttendance' => fn($q) => $q->whereDate('work_date', $workDate),
            'todayAttendance.group'
        ])
            ->where('is_active', true)
            ->whereHas('groupHistories', function ($q) use ($workDate) {
                $q->where('start_date', '<=', $workDate)
                    ->where(fn($q2) => $q2->whereNull('end_date')->orWhere('end_date', '>=', $workDate));
            });

        // 絞り込み
        if ($request->filled('worker_id')) {
            $query->where('id', $request->worker_id);
        }

        $workers = $query->orderBy('id')->get();

        // フィルタリング（未退勤のみ）
        if ($request->filled('only_working')) {
            $workers = $workers->filter(fn($w) => $w->todayAttendance && !$w->todayAttendance->clock_out);
        }

        // 集計
        $counts = [
            'total'     => $workers->count(),
            'working'   => $workers->filter(fn($w) => $w->todayAttendance && !$w->todayAttendance->clock_out)->count(),
            'missing'   => $workers->whereNull('todayAttendance')->count(),
            'completed' => $workers->filter(fn($w) => $w->todayAttendance?->clock_out)->count(),
        ];

        return view('attendance_v2.index', array_merge(compact('workers', 'workDate'), $counts));
    }

    /**
     * 出勤
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'group_id'  => 'required|exists:workergroups_v2,id',
            'comment'   => 'nullable|string|max:1000',
        ]);

        $attendance = AttendanceV2::firstOrCreate(
            ['worker_id' => $request->worker_id, 'work_date' => today()],
            ['site_id' => $request->site_id ?? 1]
        );

        if (!$attendance->clock_in) {
            $attendance->clock_in = now();
        }

        $attendance->fill([
            'group_id' => $request->group_id,
            'comment'  => $request->comment,
        ])->save();

        return back()->with('success', '出勤打刻しました');
    }

    /**
     * 退勤
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'group_id'  => 'required|exists:workergroups_v2,id',
            'comment'   => 'nullable|string|max:1000',
        ]);

        $attendance = AttendanceV2::where('worker_id', $request->worker_id)
            ->where('work_date', today())
            ->firstOrFail();

        if ($attendance->clock_in && !$attendance->clock_out) {
            $attendance->clock_out = now();
        }

        $attendance->fill([
            'group_id' => $request->group_id,
            'comment'  => $request->comment,
        ])->save();

        return back()->with('success', '退勤打刻しました');
    }

    /**
     * 打刻画面 (QR)
     */
    public function create($token)
    {
        $worker = WorkerV2::where('qr_token', $token)->firstOrFail();
        $today = today();

        $attendance = AttendanceV2::where('worker_id', $worker->id)
            ->where('work_date', $today)
            ->first();

        // 有効な班の取得クエリを共通化
        $baseGroupQuery = DB::table('worker_group_histories')
            ->where('start_date', '<=', $today)
            ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $today));

        $defaultGroupId = (clone $baseGroupQuery)->where('worker_id', $worker->id)->value('group_id');
        $activeGroupIds = (clone $baseGroupQuery)->pluck('group_id')->unique();

        if ($defaultGroupId) {
            $activeGroupIds->push($defaultGroupId);
        }

        $groups = WorkerGroupV2::whereIn('id', $activeGroupIds)->orderBy('name')->get();

        return view('attendance_v2.create', compact('worker', 'attendance', 'groups', 'defaultGroupId'));
    }

    /**
     * コメント更新
     */
    public function updateComment(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers_v2,id',
            'comment'   => 'nullable|string|max:1000',
        ]);

        AttendanceV2::updateOrCreate(
            ['worker_id' => $request->worker_id, 'work_date' => today()],
            ['comment' => $request->comment]
        );

        return back()->with('success', 'コメント保存しました');
    }

    /**
     * CSV出力
     */
    public function exportCsv(Request $request)
    {
        $targetMonth = $request->target_month ?? now()->format('Y-m');
        $startDate = Carbon::parse($targetMonth . '-01')->startOfMonth();
        $endDate = Carbon::parse($targetMonth . '-01')->endOfMonth();

        $attendances = AttendanceV2::with(['worker', 'group'])
            ->whereBetween('work_date', [$startDate, $endDate])
            ->orderBy('work_date')->orderBy('worker_id')
            ->get();

        $response = new StreamedResponse(function () use ($attendances) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM

            fputcsv($handle, ['日付', '作業員ID', '氏名', '班ID', '班名', '出勤', '退勤', 'コメント']);

            foreach ($attendances as $atd) {
                fputcsv($handle, [
                    $atd->work_date?->format('Y-m-d'),
                    $atd->worker_id,
                    $atd->worker->name ?? '',
                    $atd->group_id,
                    $atd->group->name ?? '',
                    $atd->clock_in?->format('H:i'),
                    $atd->clock_out?->format('H:i'),
                    $atd->comment,
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename={$targetMonth}_attendance.csv");

        return $response;
    }
}
