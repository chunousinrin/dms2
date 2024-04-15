<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrlController extends Controller
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
    public function errl()
    {
        return view('errl.errl');
    }
    public function errl_input()
    {
        return view('errl.errl_input');
    }
    public function errl_submit()
    {
        return view('errl.errl_submit');
    }
    public function errl_list_print()
    {
        return view('errl.errl_list_print');
    }
}
