<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function customer()
    {
        return view('master.customer.customer');
    }
    public function customer_reg()
    {
        return view('master.customer.customer_reg');
    }
    public function classication()
    {
        return view('master.classication.classication');
    }
    public function bank()
    {
        return view('master.bank.bank');
    }
    public function dailyreport()
    {
        return view('master.dailyreport.dailyreport');
    }
    public function users()
    {
        return view('master.users.users');
    }
    public function user()
    {
        return view('admin.user.user');
    }
    public function company()
    {
        return view('admin.company.company');
    }
    public function attendance()
    {
        return view('attendance.attendance');
    }
    public function at4()
    {
        return view('attendance.at4');
    }
}
