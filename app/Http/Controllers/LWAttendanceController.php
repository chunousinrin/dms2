<?php

namespace App\Http\Controllers;

use App\Models\LWAttendance;
use Illuminate\Http\Request;

class LWAttendanceController extends Controller
{
    public function index(Request $request)
    {
        // 今月のデータを取得（例）
        $month = $request->query('month', now()->format('Y-m'));

        $attendances = LWAttendance::where('work_date', 'like', "$month%")
            ->orderBy('work_date', 'desc')
            ->get();

        // ビューのパスを lw.attendance.index に指定
        return view('lw.attendance.index', compact('attendances', 'month'));
    }
}
