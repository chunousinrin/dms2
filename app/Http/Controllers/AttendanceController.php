<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function atmain()
    {
        return view('attendance.atmain');
    }
    public function worker()
    {
        return view('attendance.worker.wat1');
    }
    public function worker_print()
    {
        return view('attendance.worker.wat5');
    }
}
