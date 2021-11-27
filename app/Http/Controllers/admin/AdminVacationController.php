<?php

namespace App\Http\Controllers\admin;

use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateVacationRequest;

class AdminVacationController extends Controller
{
    public function dashboard()
    {
        $vacations = Vacation::all();
        
        return view('admin.dashboard', ['vacations' => $vacations]);
    }

    public function store(AdminUpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->response_message = $request->response_message;
        $vacation->status = $request->status;
        $vacation->save();

        session()->flash('successMessage', 'تغییرات با موفقیت ثبت شد');
        return redirect()->back();
    }
}
