<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function license()
    {
        return view('work.license');
    }

    public function license_update()
    {
        return view('work.license_update');
    }
    public function license_input()
    {
        return view('work.license_input');
    }
    public function license_conf()
    {
        return view('work.license_conf');
    }
    public function sending()
    {
        return view('work.sending');
    }
    public function sending_preview()
    {
        return view('work.sending_preview');
    }

    public function calendar()
    {
        return view('work.calendar');
    }
    public function sinrinbo()
    {
        return view('work.sinrinbo.sinrinbo');
    }
    public function sinrinbo_export()
    {
        return view('work.sinrinbo.sinrinbo_export');
    }
}
