<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Requests\CreateVacationRequest;

class VacationController extends Controller
{
    public function dashboard()
    {
        $vacations = Vacation::where('user_id', auth()->user()->id)->get();

        return view('vacation.dashboard', ['vacations' => $vacations]);
    }

    public function create()
    {
        return view('vacation.create');
    }

    public function store(CreateVacationRequest $request) 
    {
        $vacation = auth()->user()->vacations()->create([
            'title' => $request->title,
            'request_message' => $request->request_message,
            'date' => $request->date,
        ]);

        $vacation->status = 'submitted';
        $vacation->save();
        
        session()->flash('successMessage', 'درخواست شما با موفقیت ثبت شد');

        return redirect()->back();
    }
}
