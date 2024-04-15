<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');

        $topics = DB::select('SELECT * FROM topic ORDER BY TopicDate DESC limit 5;');
        $licenses = DB::select('SELECT * FROM license_history WHERE lmt BETWEEN 0 AND 60;');
        $releases = DB::select('SELECT * FROM all_document;');

        return view('home')->with([
            'topics' => $topics,
            'licenses' => $licenses,
            'releases' => $releases,
        ]);
    }
    public function home()
    {
        return redirect('/');
    }
}
