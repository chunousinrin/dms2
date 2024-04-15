<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Billcontroller extends Controller
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

    public function bill()
    {
        return view('bill.bill');
    }
    public function bill_input()
    {
        return view('bill.bill_input');
    }
    public function bill_conf()
    {
        return view('bill.bill_conf');
    }
    public function bill_preview()
    {
        return view('bill.bill_preview');
    }
    public function bill_submit()
    {
        return view('bill.bill_submit');
    }
    public function bill_delete()
    {
        return view('bill.bill_delete');
    }
    public function bill_repreview()
    {
        return view('bill.bill_repreview');
    }
    public function bill_processing()
    {
        return view('bill.bill_processing');
    }
    public function deliveryslip()
    {
        return view('bill.deliveryslip');
    }
    public function deliveryslip_repreview()
    {
        return view('bill.deliveryslip_repreview');
    }
    public function bill_list()
    {
        return view('bill.bill_list');
    }
    public function bill_list_print()
    {
        return view('bill.bill_list_print');
    }
}
