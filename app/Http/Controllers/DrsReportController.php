<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrsReportController extends Controller
{
    public function index()
    {
        $reports = DB::select('SELECT drs_reports.*,drs_weathers.Weather as tenki1 FROM drs_reports LEFT JOIN drs_weathers ON drs_reports.Weather1=drs_weathers.WeatherID;');
        $reports = ['reports' => $reports];
        return view('drs.drs_history', $reports);
    }
}
