<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrsController extends Controller
{
    public function drs()
    {
        return view('drs.drs');
    }
    public function drs_input()
    {
        return view('drs.drs_input');
    }
    public function drs_history()
    {
        return view('drs.drs_history');
    }
}
