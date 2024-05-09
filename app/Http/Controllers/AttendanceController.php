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
}
