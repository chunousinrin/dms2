<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SinrinboController extends Controller
{
    public function sinrinbo()
    {
        return view('sinrinbo.sinrinbo');
    }
    public function sinrinbo_export()
    {
        return view('work.sinrinbo.sinrinbo_export');
    }
}
