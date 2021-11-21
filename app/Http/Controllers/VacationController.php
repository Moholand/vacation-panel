<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VacationController extends Controller
{
    public function dashboard()
    {
        return view('vacation.dashboard');
    }
}
