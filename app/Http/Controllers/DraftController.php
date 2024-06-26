<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DraftController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function draft()
    {
        return view('draft.draft');
    }
    public function draft_preview()
    {
        return view('draft.draft_preview');
    }
    public function draft_repreview()
    {
        return view('draft.draft_repreview');
    }
}
