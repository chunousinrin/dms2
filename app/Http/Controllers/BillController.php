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
}
