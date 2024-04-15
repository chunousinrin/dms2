<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Draftcontroller extends Controller
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


    public function draft()
    {
        return view('draft.draft');
    }
    public function draft_input()
    {
        return view('draft.draft_input');
    }
    public function draft_restate()
    {
        return view('draft.draft_restate');
    }
    public function draft_conf()
    {
        return view('draft.draft_conf');
    }
    public function draft_preview()
    {
        return view('draft.draft_preview');
    }
    public function draft_repreview()
    {
        return view('draft.draft_repreview');
    }
    public function draft_submit()
    {
        return view('draft.draft_submit');
    }
    public function draft_delete()
    {
        return view('draft.draft_delete');
    }
    public function draft_com_submit()
    {
        return view('draft.draft_com_submit');
    }
    public function wareki()
    {
        return view('edt.wareki');
    }
}
