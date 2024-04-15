<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function user_list()
    {
        return view('admin.user_list');
    }
    public function user_edit()
    {
        return view('admin.user_edit');
    }
    public function user_workingtime()
    {
        return view('admin.user_workingtime');
    }
    public function working_list()
    {
        return view('admin.working_list');
    }
}
