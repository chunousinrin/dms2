<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
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
    public function equipment()
    {
        return view('equipment.equipment');
    }
    public function eq42()
    {
        return view('equipment.eq42');
    }
}
