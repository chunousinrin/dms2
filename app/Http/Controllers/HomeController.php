<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkerV2\AttendanceV2;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*public function index()
    {
        //return view('home');

        $topics = DB::select('SELECT * FROM topic ORDER BY TopicDate DESC limit 5;');
        $licenses = DB::select('SELECT * FROM license_history WHERE lmt BETWEEN 0 AND 60;');
        $releases = DB::select('SELECT * FROM all_document;');

        return view('home')->with([
            'topics' => $topics,
            'licenses' => $licenses,
            'releases' => $releases,
        ]);
    }*/
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
    public function attendanceWidget()
    {
        $todayAttendances = AttendanceV2::with(['worker', 'group'])
            ->whereDate('work_date', today())
            ->orderBy('worker_id')
            ->get();

        $totalCount = $todayAttendances->count();

        $workingAttendances = $todayAttendances
            ->whereNull('clock_out');

        $workingCount = $workingAttendances->count();

        return view('widgets.attendance', compact(
            'totalCount',
            'workingCount',
            'workingAttendances'
        ));
    }

    public function home()
    {
        return redirect('/');
    }
}
