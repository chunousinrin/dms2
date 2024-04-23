<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstimateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function estimate()
    {
        return view('estimate.estimate');
    }
    public function estimate_list()
    {
        return view('estimate.estimate_list');
    }
    public function estimate_send()
    {
        return view('estimate.estimate_send');
    }
    public function estimate_input()
    {
        return view('estimate.estimate_input');
    }
    public function estimate_conf()
    {
        return view('estimate.estimate_conf');
    }
    public function estimate_preview()
    {
        return view('estimate.estimate_preview');
    }
    public function estimate_submit()
    {
        return view('estimate.estimate_submit');
    }
    public function estimate_delete()
    {
        return view('estimate.estimate_delete');
    }
    public function estimate_repreview()
    {
        return view('estimate.estimate_repreview');
    }
    public function estimate_to_bill()
    {
        return view('estimate.estimate_to_bill');
    }
    public function estimate2_input()
    {
        return view('estimate.estimate2_input');
    }
    public function estimate2_conf()
    {
        return view('estimate.estimate2_conf');
    }
    public function estimate2_submit()
    {
        return view('estimate.estimate2_submit');
    }
    public function estimate2_repreview()
    {
        return view('estimate.estimate2_repreview');
    }
}
