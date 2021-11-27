<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Requests\CreateVacationRequest;
use App\Http\Requests\UpdateVacationRequest;

class VacationController extends Controller
{
    public function dashboard()
    {
        if(auth()->user()->isAdmin) {
            return redirect()->route('admin.dashboard');
        }

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
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);

        $vacation->status = 'submitted';
        $vacation->save();
        
        session()->flash('successMessage', 'درخواست شما با موفقیت ثبت شد');

        return redirect()->back();
    }

    public function edit(Vacation $vacation) 
    {
        return view('vacation.create', ['vacation' => $vacation]);
    }

    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->title = $request->title;
        $vacation->request_message = $request->request_message;
        $vacation->from_date = $request->from_date;
        $vacation->to_date = $request->to_date;
        $vacation->save();

        session()->flash('successMessage', 'درخواست شما با موفقیت ویرایش شد');

        return redirect()->back();
    }

    public function destroy(Vacation $vacation) 
    {
        $vacation->delete();

        session()->flash('successMessage', 'درخواست شما با موفقیت حذف گردید');
        return redirect()->back();
    }
}
