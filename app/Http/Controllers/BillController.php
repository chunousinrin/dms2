<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function bill()
    {
        return view('bill.bill');
    }
    public function bill_preview()
    {
        return view('bill.bill_preview');
    }
    public function bill_repreview()
    {
        return view('bill.bill_repreview');
    }
    public function deliveryslip()
    {
        return view('bill.deliveryslip');
    }
    public function deliveryslip_repreview()
    {
        return view('bill.deliveryslip_repreview');
    }
    public function bill_list_print()
    {
        return view('bill.bill_list_print');
    }
}
