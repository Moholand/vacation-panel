<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $vacations = Vacation::where('user_id', auth()->user()->id)
            ->searchInTitle()
            ->filterByStatus()
            ->filterByDate()
            ->orderBy('updated_at', 'DESC')
            ->paginate($request->perPage ?? 10) // 10 is the default perPage
            ->withQueryString();

        return view('user.dashboard', compact('vacations'));
    }

    public function create()
    {
        return view('user.create');
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

        $vacation->save();
        
        session()->flash('successMessage', 'درخواست شما با موفقیت ثبت شد');

        return redirect()->back();
    }

    public function edit(Vacation $vacation) 
    {
        return view('user.create', ['vacation' => $vacation]);
    }

    public function update(UpdateVacationRequest $request, Vacation $vacation)
    {
        $vacation->update([
            'title' => $request->title,
            'request_message' => $request->request_message,
            'type' => $request->type,
            'mode' => $request->mode,
            'from_date' => $request->from_date
        ]);

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

    public function destroy($slug) 
    {
        $vacation = Vacation::withTrashed()->where([['user_id', auth()->user()->id], ['slug', $slug]])->first();

        if($vacation->trashed()) {
            $vacation->forceDelete();
            $message = 'درخواست شما با موفقیت حذف گردید';
        } else {
            $vacation->delete();
            $message = 'درخواست شما با موفقیت به زباله‌دان منتقل گردید';
        }

        return redirect()->back()->with('successMessage', $message);
    }

    public function trashed(Request $request)
    {
        $vacations = Vacation::onlyTrashed()
        ->where('user_id', auth()->user()->id)
        ->searchInTitle()
        ->filterByDate()
        ->orderBy('updated_at', 'DESC')
        ->paginate($request->perPage ?? 10) // 10 is the default perPage
        ->withQueryString();

        return view('user.dashboard', compact('vacations'));
    }

    public function restore($slug)
    {
        Vacation::withTrashed()->where([['user_id', auth()->user()->id], ['slug', $slug]])->restore();

        return redirect()->back()->with('successMessage', 'درخواست شما با موفقیت بازیابی گردید');
    }
}
