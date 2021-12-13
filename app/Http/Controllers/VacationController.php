<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Facades\Verta;
use App\Http\Requests\CreateVacationRequest;
use App\Http\Requests\UpdateVacationRequest;

class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified.check', ['except' => ['index']]);
    }

    public function index(Request $request)
    {
        if(auth()->user()->isAdmin) {
            return redirect()->route('admin.dashboard');
        }

        if($request->has('search') && $request->search !== null) {
            $vacations = Vacation::where('user_id', auth()->user()->id)->where('title', 'LIKE', '%' . $request->search . '%')->orderBy('updated_at', 'DESC')->get();
        } else {
            $vacations = Vacation::where('user_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->get();
        }

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
            'type' => $request->type,
            'mode' => $request->mode,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'from_hour' => $request->from_hour,
            'to_hour' => $request->to_hour,
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
        $vacation->type = $request->type;
        $vacation->mode = $request->mode;
        $vacation->from_date = $request->from_date;
        if($request->mode === 'daily') {
            $vacation->to_date = $request->to_date;
        }
        if($request->mode === 'hourly') {
            $vacation->from_hour = $request->from_hour;
            $vacation->to_hour = $request->to_hour;
        }
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
